<?php
namespace App\Controllers\Web;

use App\Auth\Auth;
use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Manga;
use Core\Exceptions\HttpException;
use Core\Exceptions\ValidationException;
use Core\Http\Response;
use Core\Http\Session;

class CategoryController extends BaseController {
    private const INDEX = '/admin/categories';

    public function index(): Response {
        return $this->view('admin/categories/index', [
            'title' => 'Categorias de mangás',
            'categories' => Category::all(),
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'admin');
    }

    public function edit(int $id): Response {
        $category = $this->findOrFail($id);

        return $this->view('admin/categories/form', [
            'title' => 'Editar categoria',
            'category' => $category,
            'errors' => Session::getFlash('errors', []),
            'error' => Session::getFlash('error'),
        ], 'admin');
    }

    public function store(): Response {
        try {
            $data = Category::validate($this->request->all());
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('old', $this->request->all());
            Session::flash('error', 'Não foi possível criar a categoria.');
            return $this->redirect(self::INDEX);
        }

        $category = Category::create($data['name'], Category::uniqueSlug($data['name']), $data['description']);

        $this->logger()->info('Categoria criada', [
            'category_id' => $category->id,
            'slug' => $category->slug,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Categoria criada com sucesso.');
        return $this->redirect(self::INDEX);
    }

    public function update(int $id): Response {
        $category = $this->findOrFail($id);

        try {
            $data = Category::validate($this->request->all(), $id);
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('error', 'Não foi possível salvar as alterações.');
            return $this->redirect(self::INDEX . '/' . $id . '/edit');
        }

        Category::update($id, $data['name'], Category::uniqueSlug($data['name'], $id), $data['description']);

        $this->logger()->info('Categoria atualizada', [
            'category_id' => $id,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Categoria atualizada com sucesso.');
        return $this->redirect(self::INDEX);
    }

    public function toggle(int $id): Response {
        $category = $this->findOrFail($id);

        Category::setActive($id, !$category->is_active);

        $this->logger()->info('Status da categoria alterado', [
            'category_id' => $id,
            'is_active' => !$category->is_active,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', $category->is_active ? 'Categoria desativada.' : 'Categoria ativada.');
        return $this->redirect(self::INDEX);
    }

    public function destroy(int $id): Response {
        $category = $this->findOrFail($id);

        if (Manga::countByCategory($id) > 0) {
            Session::flash('error', 'Não é possível excluir: existem mangás vinculados a esta categoria.');
            return $this->redirect(self::INDEX);
        }

        Category::delete($id);

        $this->logger()->info('Categoria excluída', [
            'category_id' => $id,
            'name' => $category->name,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Categoria excluída.');
        return $this->redirect(self::INDEX);
    }

    private function findOrFail(int $id): Category {
        $category = Category::find($id);
        if ($category === null) {
            throw new HttpException(404, 'Categoria não encontrada.');
        }
        return $category;
    }
}
