<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Core\Http\Response;

class AdminController extends BaseController {
    public function index(): Response {
        return $this->view('admin/dashboard', [
            'title' => 'Administração',
            'page' => 'admin-dashboard',
        ], 'admin');
    }
}
