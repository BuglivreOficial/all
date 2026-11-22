<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Manga;
use Core\Http\Response;
use Core\Http\Session;

class HomeController extends BaseController {
    public function index(): Response {
        return $this->view('home', [
            'title' => 'Início',
            'logged' => Session::has('user_id'),
            'featured' => Manga::latest(12),
            'categories' => Category::all(true),
        ], 'app');
    }
}
