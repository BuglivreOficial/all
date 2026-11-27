<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Core\Http\Response;

class MangaTypeController extends BaseController {
    public function index(): Response {
        return $this->view('admin/types/index', [
            'title' => 'Tipos de mangá',
            'page' => 'admin-types',
            'mode' => 'index',
        ], 'admin');
    }

    public function edit(int $id): Response {
        return $this->view('admin/types/form', [
            'title' => 'Editar tipo',
            'page' => 'admin-types',
            'mode' => 'edit',
            'id' => $id,
        ], 'admin');
    }
}
