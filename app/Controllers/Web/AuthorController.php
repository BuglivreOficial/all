<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Core\Http\Response;

class AuthorController extends BaseController {
    public function index(): Response {
        return $this->view('admin/authors/index', [
            'title' => 'Autores',
            'page' => 'admin-authors',
            'mode' => 'index',
        ], 'admin');
    }

    public function edit(int $id): Response {
        return $this->view('admin/authors/form', [
            'title' => 'Editar autor',
            'page' => 'admin-authors',
            'mode' => 'edit',
            'id' => $id,
        ], 'admin');
    }
}
