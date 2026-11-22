<?php
namespace App\Controllers\Web;

use App\Auth\Auth;
use App\Controllers\BaseController;
use App\Models\Author;
use App\Models\Category;
use App\Models\Manga;
use App\Models\MangaType;
use App\Services\CoverStorage;
use Core\Exceptions\HttpException;
use Core\Exceptions\ValidationException;
use Core\Http\Response;
use Core\Http\Session;

class MangaController extends BaseController {
    private const INDEX = '/admin/mangas';

    public function index(): Response {
        $search = trim((string) $this->request->query('q', ''));
        $rawCategory = $this->request->query('category');
        $categoryId = ($rawCategory === null || $rawCategory === '') ? null : (int) $rawCategory;
        $rawType = $this->request->query('type');
        $typeId = ($rawType === null || $rawType === '') ? null : (int) $rawType;

        return $this->view('admin/mangas/index', [
            'title' => 'Mangás',
            'mangas' => Manga::all($search, $categoryId, $typeId),
            'categories' => Category::all(),
            'types' => MangaType::all(),
            'search' => $search,
            'categoryId' => $categoryId,
            'typeId' => $typeId,
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'admin');
    }

    public function create(): Response {
        $categories = Category::all();
        if ($categories === []) {
            Session::flash('error', 'Cadastre ao menos uma categoria antes de criar mangás.');
            return $this->redirect(self::INDEX);
        }

        if (MangaType::all() === []) {
            Session::flash('error', 'Cadastre ao menos um tipo antes de criar mangás.');
            return $this->redirect(self::INDEX);
        }

        return $this->view('admin/mangas/form', [
            'title' => 'Novo mangá',
            'manga' => null,
            'categories' => $categories,
            'types' => MangaType::all(),
            'authors' => Author::all(),
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
            'error' => Session::getFlash('error'),
        ], 'admin');
    }

    public function store(): Response {
        try {
            $data = Manga::validate($this->request->all());
            $data['cover'] = $this->resolveCover($data['cover']);
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('old', $this->request->all());
            Session::flash('error', 'Não foi possível criar o mangá.');
            return $this->redirect(self::INDEX . '/create');
        }

        $data['slug'] = Manga::uniqueSlug($data['title']);
        $manga = Manga::create($data);

        $this->logger()->info('Mangá criado', [
            'manga_id' => $manga->id,
            'slug' => $manga->slug,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Mangá criado com sucesso.');
        return $this->redirect(self::INDEX);
    }

    public function edit(int $id): Response {
        $manga = $this->findOrFail($id);

        return $this->view('admin/mangas/form', [
            'title' => 'Editar mangá',
            'manga' => $manga,
            'categories' => Category::all(),
            'types' => MangaType::all(),
            'authors' => Author::all(),
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
            'error' => Session::getFlash('error'),
        ], 'admin');
    }

    public function update(int $id): Response {
        $this->findOrFail($id);

        try {
            $data = Manga::validate($this->request->all(), $id);
            $data['cover'] = $this->resolveCover($data['cover']);
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('old', $this->request->all());
            Session::flash('error', 'Não foi possível salvar as alterações.');
            return $this->redirect(self::INDEX . '/' . $id . '/edit');
        }

        $data['slug'] = Manga::uniqueSlug($data['title'], $id);
        Manga::update($id, $data);

        $this->logger()->info('Mangá atualizado', [
            'manga_id' => $id,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Mangá atualizado com sucesso.');
        return $this->redirect(self::INDEX);
    }

    public function toggle(int $id): Response {
        $manga = $this->findOrFail($id);

        Manga::setActive($id, !$manga->is_active);

        $this->logger()->info('Status do mangá alterado', [
            'manga_id' => $id,
            'is_active' => !$manga->is_active,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', $manga->is_active ? 'Mangá desativado.' : 'Mangá ativado.');
        return $this->redirect(self::INDEX);
    }

    public function destroy(int $id): Response {
        $manga = $this->findOrFail($id);

        Manga::delete($id);

        $this->logger()->info('Mangá excluído', [
            'manga_id' => $id,
            'title' => $manga->title,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Mangá excluído.');
        return $this->redirect(self::INDEX);
    }

    /**
     * Usa o caminho informado ou, se houver arquivo, salva a capa no servidor.
     *
     * @throws ValidationException
     */
    private function resolveCover(?string $url): ?string {
        $file = $this->request->file('cover_file');
        if ($file === null || (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return $url;
        }

        return (new CoverStorage())->upload($file, 'covers');
    }

    private function findOrFail(int $id): Manga {
        $manga = Manga::find($id);
        if ($manga === null) {
            throw new HttpException(404, 'Mangá não encontrado.');
        }
        return $manga;
    }
}
