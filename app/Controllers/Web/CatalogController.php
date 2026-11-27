<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Core\Http\Response;

class CatalogController extends BaseController {
    public function index(): Response {
        return $this->view('mangas/index', [
            'title' => 'Catálogo de mangás',
            'page' => 'catalog',
        ], 'app');
    }

    public function show(string $slug): Response {
        return $this->view('mangas/show', [
            'title' => 'Mangá',
            'page' => 'manga-show',
            'slug' => $slug,
        ], 'app');
    }
}
