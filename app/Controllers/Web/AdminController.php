<?php
namespace App\Controllers\Web;

use App\Auth\Auth;
use App\Controllers\BaseController;
use App\Models\User;
use Core\Http\Response;

class AdminController extends BaseController {
    public function index(): Response {
        return $this->view('admin/dashboard', [
            'title' => 'Administração',
            'user' => Auth::user($this->request),
            'users' => User::latest(50),
        ], 'admin');
    }
}
