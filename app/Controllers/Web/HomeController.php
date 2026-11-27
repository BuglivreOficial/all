<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Core\Http\Response;

class HomeController extends BaseController {
    public function index(): Response {
        return $this->view('home', [
            'title' => 'Início',
            'page' => 'home',
        ], 'app');
    }
}
