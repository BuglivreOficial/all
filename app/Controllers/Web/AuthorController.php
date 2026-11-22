<?php
namespace App\Controllers\Web;

use App\Auth\Auth;
use App\Controllers\BaseController;
use App\Models\Author;
use App\Models\Manga;
use Core\Exceptions\HttpException;
use Core\Exceptions\ValidationException;
use Core\Http\Response;
use Core\Http\Session;

class AuthorController extends BaseController {
    private const INDEX = '/admin/authors';

    public function index(): Response {
        return $this->view('admin/authors/index', [
            'title' => 'Autores',
            'authors' => Author::all(),
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'admin');
    }

    public function edit(int $id): Response {
        $author = $this->findOrFail($id);

        return $this->view('admin/authors/form', [
            'title' => 'Editar autor',
            'author' => $author,
            'errors' => Session::getFlash('errors', []),
            'error' => Session::getFlash('error'),
        ], 'admin');
    }

    public function store(): Response {
        try {
            $data = Author::validate($this->request->all());
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('old', $this->request->all());
            Session::flash('error', 'Não foi possível criar o autor.');
            return $this->redirect(self::INDEX);
        }

        $author = Author::create($data['name'], Author::uniqueSlug($data['name']), $data['bio']);

        $this->logger()->info('Autor criado', [
            'author_id' => $author->id,
            'slug' => $author->slug,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Autor criado com sucesso.');
        return $this->redirect(self::INDEX);
    }

    public function update(int $id): Response {
        $this->findOrFail($id);

        try {
            $data = Author::validate($this->request->all(), $id);
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('error', 'Não foi possível salvar as alterações.');
            return $this->redirect(self::INDEX . '/' . $id . '/edit');
        }

        Author::update($id, $data['name'], Author::uniqueSlug($data['name'], $id), $data['bio']);

        $this->logger()->info('Autor atualizado', [
            'author_id' => $id,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Autor atualizado com sucesso.');
        return $this->redirect(self::INDEX);
    }

    public function toggle(int $id): Response {
        $author = $this->findOrFail($id);

        Author::setActive($id, !$author->is_active);

        $this->logger()->info('Status do autor alterado', [
            'author_id' => $id,
            'is_active' => !$author->is_active,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', $author->is_active ? 'Autor desativado.' : 'Autor ativado.');
        return $this->redirect(self::INDEX);
    }

    public function destroy(int $id): Response {
        $author = $this->findOrFail($id);

        if (Manga::countByAuthor($id) > 0) {
            Session::flash('error', 'Não é possível excluir: existem mangás vinculados a este autor.');
            return $this->redirect(self::INDEX);
        }

        Author::delete($id);

        $this->logger()->info('Autor excluído', [
            'author_id' => $id,
            'name' => $author->name,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Autor excluído.');
        return $this->redirect(self::INDEX);
    }

    private function findOrFail(int $id): Author {
        $author = Author::find($id);
        if ($author === null) {
            throw new HttpException(404, 'Autor não encontrado.');
        }
        return $author;
    }
}
