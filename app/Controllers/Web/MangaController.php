<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Core\Http\Response;

class MangaController extends BaseController {
    public function index(): Response {
        return $this->view('admin/mangas/index', [
            'title' => 'Mangás',
            'page' => 'admin-mangas',
            'mode' => 'index',
        ], 'admin');
    }

    public function create(): Response {
        return $this->view('admin/mangas/form', [
            'title' => 'Novo mangá',
            'page' => 'admin-mangas',
            'mode' => 'create',
            'id' => null,
        ], 'admin');
    }

    public function edit(int $id): Response {
        return $this->view('admin/mangas/form', [
            'title' => 'Editar mangá',
            'page' => 'admin-mangas',
            'mode' => 'edit',
            'id' => $id,
        ], 'admin');
    }
}
