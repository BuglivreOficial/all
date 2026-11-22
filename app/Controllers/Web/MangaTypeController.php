<?php
namespace App\Controllers\Web;

use App\Auth\Auth;
use App\Controllers\BaseController;
use App\Models\Manga;
use App\Models\MangaType;
use Core\Exceptions\HttpException;
use Core\Exceptions\ValidationException;
use Core\Http\Response;
use Core\Http\Session;

class MangaTypeController extends BaseController {
    private const INDEX = '/admin/types';

    public function index(): Response {
        return $this->view('admin/types/index', [
            'title' => 'Tipos de mangá',
            'types' => MangaType::all(),
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'admin');
    }

    public function edit(int $id): Response {
        $type = $this->findOrFail($id);

        return $this->view('admin/types/form', [
            'title' => 'Editar tipo',
            'type' => $type,
            'errors' => Session::getFlash('errors', []),
            'error' => Session::getFlash('error'),
        ], 'admin');
    }

    public function store(): Response {
        try {
            $data = MangaType::validate($this->request->all());
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('old', $this->request->all());
            Session::flash('error', 'Não foi possível criar o tipo.');
            return $this->redirect(self::INDEX);
        }

        $type = MangaType::create($data['name'], MangaType::uniqueSlug($data['name']), $data['description']);

        $this->logger()->info('Tipo de mangá criado', [
            'type_id' => $type->id,
            'slug' => $type->slug,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Tipo criado com sucesso.');
        return $this->redirect(self::INDEX);
    }

    public function update(int $id): Response {
        $this->findOrFail($id);

        try {
            $data = MangaType::validate($this->request->all(), $id);
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('error', 'Não foi possível salvar as alterações.');
            return $this->redirect(self::INDEX . '/' . $id . '/edit');
        }

        MangaType::update($id, $data['name'], MangaType::uniqueSlug($data['name'], $id), $data['description']);

        $this->logger()->info('Tipo de mangá atualizado', [
            'type_id' => $id,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Tipo atualizado com sucesso.');
        return $this->redirect(self::INDEX);
    }

    public function toggle(int $id): Response {
        $type = $this->findOrFail($id);

        MangaType::setActive($id, !$type->is_active);

        $this->logger()->info('Status do tipo alterado', [
            'type_id' => $id,
            'is_active' => !$type->is_active,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', $type->is_active ? 'Tipo desativado.' : 'Tipo ativado.');
        return $this->redirect(self::INDEX);
    }

    public function destroy(int $id): Response {
        $type = $this->findOrFail($id);

        if (Manga::countByType($id) > 0) {
            Session::flash('error', 'Não é possível excluir: existem mangás vinculados a este tipo.');
            return $this->redirect(self::INDEX);
        }

        MangaType::delete($id);

        $this->logger()->info('Tipo de mangá excluído', [
            'type_id' => $id,
            'name' => $type->name,
            'user_id' => Auth::user($this->request)?->id,
        ]);

        Session::flash('success', 'Tipo excluído.');
        return $this->redirect(self::INDEX);
    }

    private function findOrFail(int $id): MangaType {
        $type = MangaType::find($id);
        if ($type === null) {
            throw new HttpException(404, 'Tipo não encontrado.');
        }
        return $type;
    }
}
