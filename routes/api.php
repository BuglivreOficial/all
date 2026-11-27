<?php

use App\Controllers\Api\AuthorController;
use App\Controllers\Api\AuthController;
use App\Controllers\Api\CategoryController;
use App\Controllers\Api\MangaController;
use App\Controllers\Api\MangaTypeController;
use App\Controllers\Api\UserController;

/**
 * Rotas da API (respostas em JSON). Todas ficam sob o prefixo /api.
 *
 * @var \Core\Routing\Router $router
 */

// Autenticação (público). Limite rígido para conter abuso/força bruta.
$router->post('/auth/register', [AuthController::class, 'register'], ['throttle:10,1']);
$router->post('/auth/login', [AuthController::class, 'login'], ['throttle:10,1']);
$router->post('/auth/logout', [AuthController::class, 'logout']);
$router->post('/auth/refresh', [AuthController::class, 'refresh'], ['throttle:10,1']);
$router->post('/auth/forgot-password', [AuthController::class, 'forgotPassword'], ['throttle:10,1']);
$router->post('/auth/reset-password', [AuthController::class, 'resetPassword'], ['throttle:10,1']);
$router->get('/auth/me', [AuthController::class, 'me']);

// Catálogo: leitura pública, escrita restrita a moderador ou superior.
$router->get('/categories', [CategoryController::class, 'index']);
$router->get('/categories/{id:int}', [CategoryController::class, 'show']);

$router->get('/types', [MangaTypeController::class, 'index']);
$router->get('/types/{id:int}', [MangaTypeController::class, 'show']);

$router->get('/authors', [AuthorController::class, 'index']);
$router->get('/authors/{id:int}', [AuthorController::class, 'show']);

$router->get('/mangas', [MangaController::class, 'index']);
$router->get('/mangas/{id:int}', [MangaController::class, 'show']);
$router->get('/mangas/slug/{slug:str}', [MangaController::class, 'showBySlug']);

// Usuários (usado pelo painel administrativo).
$router->get('/users', [UserController::class, 'index'], ['auth', 'role:moderador']);

$router->group('/categories', function ($router) {
    $router->post('/', [CategoryController::class, 'store']);
    $router->put('/{id:int}', [CategoryController::class, 'update']);
    $router->patch('/{id:int}', [CategoryController::class, 'update']);
    $router->post('/{id:int}/status', [CategoryController::class, 'toggle']);
    $router->delete('/{id:int}', [CategoryController::class, 'destroy']);
}, ['auth', 'role:moderador']);

$router->group('/types', function ($router) {
    $router->post('/', [MangaTypeController::class, 'store']);
    $router->put('/{id:int}', [MangaTypeController::class, 'update']);
    $router->patch('/{id:int}', [MangaTypeController::class, 'update']);
    $router->post('/{id:int}/status', [MangaTypeController::class, 'toggle']);
    $router->delete('/{id:int}', [MangaTypeController::class, 'destroy']);
}, ['auth', 'role:moderador']);

$router->group('/authors', function ($router) {
    $router->post('/', [AuthorController::class, 'store']);
    $router->put('/{id:int}', [AuthorController::class, 'update']);
    $router->patch('/{id:int}', [AuthorController::class, 'update']);
    $router->post('/{id:int}/status', [AuthorController::class, 'toggle']);
    $router->delete('/{id:int}', [AuthorController::class, 'destroy']);
}, ['auth', 'role:moderador']);

$router->group('/mangas', function ($router) {
    $router->post('/', [MangaController::class, 'store']);
    // POST {id} aceita multipart (upload de capa); PUT/PATCH recebem JSON.
    $router->post('/{id:int}', [MangaController::class, 'update']);
    $router->put('/{id:int}', [MangaController::class, 'update']);
    $router->patch('/{id:int}', [MangaController::class, 'update']);
    $router->post('/{id:int}/status', [MangaController::class, 'toggle']);
    $router->delete('/{id:int}', [MangaController::class, 'destroy']);
}, ['auth', 'role:moderador']);
