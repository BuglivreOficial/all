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
 * Rotas da área web (respostas em HTML).
 *
 * @var \Core\Routing\Router $router
 */

$router->get('/', [HomeController::class, 'index']);

// Catálogo público
$router->get('/mangas', [CatalogController::class, 'index']);
$router->get('/mangas/{slug}', [CatalogController::class, 'show']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [AuthController::class, 'dashboard'], ['auth']);

// Área administrativa: exige login e perfil de moderador ou superior.
$router->group('/admin', function ($router) {
    $router->get('/', [AdminController::class, 'index']);

    // Categorias de mangás
    $router->get('/categories', [CategoryController::class, 'index']);
    $router->post('/categories', [CategoryController::class, 'store']);
    $router->get('/categories/{id:int}/edit', [CategoryController::class, 'edit']);
    $router->post('/categories/{id:int}', [CategoryController::class, 'update']);
    $router->post('/categories/{id:int}/status', [CategoryController::class, 'toggle']);
    $router->post('/categories/{id:int}/delete', [CategoryController::class, 'destroy']);

    // Tipos de mangá
    $router->get('/types', [MangaTypeController::class, 'index']);
    $router->post('/types', [MangaTypeController::class, 'store']);
    $router->get('/types/{id:int}/edit', [MangaTypeController::class, 'edit']);
    $router->post('/types/{id:int}', [MangaTypeController::class, 'update']);
    $router->post('/types/{id:int}/status', [MangaTypeController::class, 'toggle']);
    $router->post('/types/{id:int}/delete', [MangaTypeController::class, 'destroy']);

    // Autores
    $router->get('/authors', [AuthorController::class, 'index']);
    $router->post('/authors', [AuthorController::class, 'store']);
    $router->get('/authors/{id:int}/edit', [AuthorController::class, 'edit']);
    $router->post('/authors/{id:int}', [AuthorController::class, 'update']);
    $router->post('/authors/{id:int}/status', [AuthorController::class, 'toggle']);
    $router->post('/authors/{id:int}/delete', [AuthorController::class, 'destroy']);

    // Mangás
    $router->get('/mangas', [MangaController::class, 'index']);
    $router->get('/mangas/create', [MangaController::class, 'create']);
    $router->post('/mangas', [MangaController::class, 'store']);
    $router->get('/mangas/{id:int}/edit', [MangaController::class, 'edit']);
    $router->post('/mangas/{id:int}', [MangaController::class, 'update']);
    $router->post('/mangas/{id:int}/status', [MangaController::class, 'toggle']);
    $router->post('/mangas/{id:int}/delete', [MangaController::class, 'destroy']);
}, ['auth', 'role:moderador']);
