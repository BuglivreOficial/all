<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Manga;
use App\Models\MangaType;
use Core\Exceptions\HttpException;
use Core\Http\Response;

class CatalogController extends BaseController {
    public function index(): Response {
        $search = trim((string) $this->request->query('q', ''));
        $rawCategory = $this->request->query('category');
        $categoryId = ($rawCategory === null || $rawCategory === '') ? null : (int) $rawCategory;
        $rawType = $this->request->query('type');
        $typeId = ($rawType === null || $rawType === '') ? null : (int) $rawType;

        return $this->view('mangas/index', [
            'title' => 'Catálogo de mangás',
            'mangas' => Manga::all($search, $categoryId, $typeId, true),
            'categories' => Category::all(true),
            'types' => MangaType::all(true),
            'search' => $search,
            'categoryId' => $categoryId,
            'typeId' => $typeId,
        ], 'app');
    }

    public function show(string $slug): Response {
        $manga = Manga::findBySlug($slug);

        if ($manga === null || !$manga->is_active) {
            throw new HttpException(404, 'Mangá não encontrado.');
        }

        return $this->view('mangas/show', [
            'title' => $manga->title,
            'manga' => $manga,
        ], 'app');
    }
}
