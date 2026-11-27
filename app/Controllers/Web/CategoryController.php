<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Core\Http\Response;

class CategoryController extends BaseController {
    public function index(): Response {
        return $this->view('admin/categories/index', [
            'title' => 'Categorias de mangás',
            'page' => 'admin-categories',
            'mode' => 'index',
        ], 'admin');
    }

    public function edit(int $id): Response {
        return $this->view('admin/categories/form', [
            'title' => 'Editar categoria',
            'page' => 'admin-categories',
            'mode' => 'edit',
            'id' => $id,
        ], 'admin');
    }
}
