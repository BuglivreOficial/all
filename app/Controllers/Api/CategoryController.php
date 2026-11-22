<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Manga;
use Core\Exceptions\HttpException;
use Core\Exceptions\ValidationException;
use Core\Http\Response;

class CategoryController extends BaseController {
    public function index(): Response {
        $onlyActive = in_array(
            strtolower((string) $this->request->query('only_active', '')),
            ['1', 'true', 'yes'],
            true
        );

        $categories = array_map(
            static fn(Category $category): array => $category->toArray(),
            Category::all($onlyActive)
        );

        return $this->ok($categories);
    }

    public function show(int $id): Response {
        return $this->ok($this->findOrFail($id)->toArray());
    }

    public function store(): Response {
        try {
            $data = Category::validate($this->request->all());
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        $category = Category::create($data['name'], Category::uniqueSlug($data['name']), $data['description']);

        $this->logger()->info('Categoria criada via API', [
            'category_id' => $category->id,
            'slug' => $category->slug,
        ]);

        return $this->created($category->toArray(), 'Categoria criada com sucesso.');
    }

    public function update(int $id): Response {
        $this->findOrFail($id);

        try {
            $data = Category::validate($this->request->all(), $id);
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        Category::update($id, $data['name'], Category::uniqueSlug($data['name'], $id), $data['description']);

        $this->logger()->info('Categoria atualizada via API', ['category_id' => $id]);

        return $this->ok(Category::find($id)?->toArray(), 'Categoria atualizada com sucesso.');
    }

    public function toggle(int $id): Response {
        $category = $this->findOrFail($id);

        Category::setActive($id, !$category->is_active);

        $this->logger()->info('Status da categoria alterado via API', [
            'category_id' => $id,
            'is_active' => !$category->is_active,
        ]);

        return $this->ok(
            Category::find($id)?->toArray(),
            $category->is_active ? 'Categoria desativada.' : 'Categoria ativada.'
        );
    }

    public function destroy(int $id): Response {
        $this->findOrFail($id);

        if (Manga::countByCategory($id) > 0) {
            return $this->error('Não é possível excluir: existem mangás vinculados a esta categoria.', 409);
        }

        Category::delete($id);

        $this->logger()->info('Categoria excluída via API', ['category_id' => $id]);

        return $this->ok(null, 'Categoria excluída.');
    }

    private function findOrFail(int $id): Category {
        $category = Category::find($id);
        if ($category === null) {
            throw new HttpException(404, 'Categoria não encontrada.');
        }
        return $category;
    }
}
