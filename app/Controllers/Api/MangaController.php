<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Manga;
use Core\Exceptions\HttpException;
use Core\Exceptions\ValidationException;
use Core\Http\Response;

class MangaController extends BaseController {
    public function index(): Response {
        $search = trim((string) $this->request->query('q', ''));
        $rawCategory = $this->request->query('category');
        $categoryId = ($rawCategory === null || $rawCategory === '') ? null : (int) $rawCategory;
        $rawType = $this->request->query('type');
        $typeId = ($rawType === null || $rawType === '') ? null : (int) $rawType;
        $onlyActive = in_array(
            strtolower((string) $this->request->query('only_active', '')),
            ['1', 'true', 'yes'],
            true
        );

        $mangas = array_map(
            static fn(Manga $manga): array => $manga->toArray(),
            Manga::all($search, $categoryId, $typeId, $onlyActive)
        );

        return $this->ok($mangas);
    }

    public function show(int $id): Response {
        return $this->ok($this->findOrFail($id)->toArray());
    }

    public function store(): Response {
        try {
            $data = Manga::validate($this->request->all());
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        $data['slug'] = Manga::uniqueSlug($data['title']);
        $manga = Manga::create($data);

        $this->logger()->info('Mangá criado via API', [
            'manga_id' => $manga->id,
            'slug' => $manga->slug,
        ]);

        return $this->created($manga->toArray(), 'Mangá criado com sucesso.');
    }

    public function update(int $id): Response {
        $this->findOrFail($id);

        try {
            $data = Manga::validate($this->request->all(), $id);
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        $data['slug'] = Manga::uniqueSlug($data['title'], $id);
        Manga::update($id, $data);

        $this->logger()->info('Mangá atualizado via API', ['manga_id' => $id]);

        return $this->ok(Manga::find($id)?->toArray(), 'Mangá atualizado com sucesso.');
    }

    public function toggle(int $id): Response {
        $manga = $this->findOrFail($id);

        Manga::setActive($id, !$manga->is_active);

        $this->logger()->info('Status do mangá alterado via API', [
            'manga_id' => $id,
            'is_active' => !$manga->is_active,
        ]);

        return $this->ok(
            Manga::find($id)?->toArray(),
            $manga->is_active ? 'Mangá desativado.' : 'Mangá ativado.'
        );
    }

    public function destroy(int $id): Response {
        $this->findOrFail($id);

        Manga::delete($id);

        $this->logger()->info('Mangá excluído via API', ['manga_id' => $id]);

        return $this->ok(null, 'Mangá excluído.');
    }

    private function findOrFail(int $id): Manga {
        $manga = Manga::find($id);
        if ($manga === null) {
            throw new HttpException(404, 'Mangá não encontrado.');
        }
        return $manga;
    }
}
