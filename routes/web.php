<?php

use App\Controllers\Web\AdminController;
use App\Controllers\Web\AuthController;
use App\Controllers\Web\AuthorController;
use App\Controllers\Web\CatalogController;
use App\Controllers\Web\CategoryController;
use App\Controllers\Web\HomeController;
use App\Controllers\Web\MangaController;
use App\Controllers\Web\MangaTypeController;

/**
 * Rotas da área web (shells HTML que consomem a API via JavaScript).
 *
 * Os dados são carregados no cliente a partir de /api; aqui apenas servimos as
 * páginas e protegemos as áreas restritas (auth / role).
 *
 * @var \Core\Routing\Router $router
 */

$router->get('/', [HomeController::class, 'index']);

// Catálogo público
$router->get('/mangas', [CatalogController::class, 'index']);
$router->get('/mangas/{slug}', [CatalogController::class, 'show']);

// Autenticação (formulários consomem /api/auth via JS).
$router->get('/login', [AuthController::class, 'showLogin']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->get('/forgot-password', [AuthController::class, 'showForgot']);
$router->get('/reset-password/{token}', [AuthController::class, 'showReset']);
$router->get('/dashboard', [AuthController::class, 'dashboard'], ['auth']);

// Área administrativa: exige login e perfil de moderador ou superior.
$router->group('/admin', function ($router) {
    $router->get('/', [AdminController::class, 'index']);

    // Categorias de mangás
    $router->get('/categories', [CategoryController::class, 'index']);
    $router->get('/categories/{id:int}/edit', [CategoryController::class, 'edit']);

    // Tipos de mangá
    $router->get('/types', [MangaTypeController::class, 'index']);
    $router->get('/types/{id:int}/edit', [MangaTypeController::class, 'edit']);

    // Autores
    $router->get('/authors', [AuthorController::class, 'index']);
    $router->get('/authors/{id:int}/edit', [AuthorController::class, 'edit']);

    // Mangás
    $router->get('/mangas', [MangaController::class, 'index']);
    $router->get('/mangas/create', [MangaController::class, 'create']);
    $router->get('/mangas/{id:int}/edit', [MangaController::class, 'edit']);
}, ['auth', 'role:moderador']);
