<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Manga;
use App\Models\MangaType;
use Core\Exceptions\HttpException;
use Core\Exceptions\ValidationException;
use Core\Http\Response;

class MangaTypeController extends BaseController {
    public function index(): Response {
        $onlyActive = in_array(
            strtolower((string) $this->request->query('only_active', '')),
            ['1', 'true', 'yes'],
            true
        );

        $types = array_map(
            static fn(MangaType $type): array => $type->toArray(),
            MangaType::all($onlyActive)
        );

        return $this->ok($types);
    }

    public function show(int $id): Response {
        return $this->ok($this->findOrFail($id)->toArray());
    }

    public function store(): Response {
        try {
            $data = MangaType::validate($this->request->all());
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        $type = MangaType::create($data['name'], MangaType::uniqueSlug($data['name']), $data['description']);

        $this->logger()->info('Tipo de mangá criado via API', [
            'type_id' => $type->id,
            'slug' => $type->slug,
        ]);

        return $this->created($type->toArray(), 'Tipo criado com sucesso.');
    }

    public function update(int $id): Response {
        $this->findOrFail($id);

        try {
            $data = MangaType::validate($this->request->all(), $id);
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        MangaType::update($id, $data['name'], MangaType::uniqueSlug($data['name'], $id), $data['description']);

        $this->logger()->info('Tipo de mangá atualizado via API', ['type_id' => $id]);

        return $this->ok(MangaType::find($id)?->toArray(), 'Tipo atualizado com sucesso.');
    }

    public function toggle(int $id): Response {
        $type = $this->findOrFail($id);

        MangaType::setActive($id, !$type->is_active);

        $this->logger()->info('Status do tipo alterado via API', [
            'type_id' => $id,
            'is_active' => !$type->is_active,
        ]);

        return $this->ok(
            MangaType::find($id)?->toArray(),
            $type->is_active ? 'Tipo desativado.' : 'Tipo ativado.'
        );
    }

    public function destroy(int $id): Response {
        $this->findOrFail($id);

        if (Manga::countByType($id) > 0) {
            return $this->error('Não é possível excluir: existem mangás vinculados a este tipo.', 409);
        }

        MangaType::delete($id);

        $this->logger()->info('Tipo de mangá excluído via API', ['type_id' => $id]);

        return $this->ok(null, 'Tipo excluído.');
    }

    private function findOrFail(int $id): MangaType {
        $type = MangaType::find($id);
        if ($type === null) {
            throw new HttpException(404, 'Tipo não encontrado.');
        }
        return $type;
    }
}
