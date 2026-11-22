<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Author;
use App\Models\Manga;
use Core\Exceptions\HttpException;
use Core\Exceptions\ValidationException;
use Core\Http\Response;

class AuthorController extends BaseController {
    public function index(): Response {
        $onlyActive = in_array(
            strtolower((string) $this->request->query('only_active', '')),
            ['1', 'true', 'yes'],
            true
        );

        $authors = array_map(
            static fn(Author $author): array => $author->toArray(),
            Author::all($onlyActive)
        );

        return $this->ok($authors);
    }

    public function show(int $id): Response {
        return $this->ok($this->findOrFail($id)->toArray());
    }

    public function store(): Response {
        try {
            $data = Author::validate($this->request->all());
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        $author = Author::create($data['name'], Author::uniqueSlug($data['name']), $data['bio']);

        $this->logger()->info('Autor criado via API', [
            'author_id' => $author->id,
            'slug' => $author->slug,
        ]);

        return $this->created($author->toArray(), 'Autor criado com sucesso.');
    }

    public function update(int $id): Response {
        $this->findOrFail($id);

        try {
            $data = Author::validate($this->request->all(), $id);
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        Author::update($id, $data['name'], Author::uniqueSlug($data['name'], $id), $data['bio']);

        $this->logger()->info('Autor atualizado via API', ['author_id' => $id]);

        return $this->ok(Author::find($id)?->toArray(), 'Autor atualizado com sucesso.');
    }

    public function toggle(int $id): Response {
        $author = $this->findOrFail($id);

        Author::setActive($id, !$author->is_active);

        $this->logger()->info('Status do autor alterado via API', [
            'author_id' => $id,
            'is_active' => !$author->is_active,
        ]);

        return $this->ok(
            Author::find($id)?->toArray(),
            $author->is_active ? 'Autor desativado.' : 'Autor ativado.'
        );
    }

    public function destroy(int $id): Response {
        $this->findOrFail($id);

        if (Manga::countByAuthor($id) > 0) {
            return $this->error('Não é possível excluir: existem mangás vinculados a este autor.', 409);
        }

        Author::delete($id);

        $this->logger()->info('Autor excluído via API', ['author_id' => $id]);

        return $this->ok(null, 'Autor excluído.');
    }

    private function findOrFail(int $id): Author {
        $author = Author::find($id);
        if ($author === null) {
            throw new HttpException(404, 'Autor não encontrado.');
        }
        return $author;
    }
}
