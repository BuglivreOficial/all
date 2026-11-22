<?php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;
use Core\Logging\Logger;
use Core\View\View;

abstract class BaseController {
    protected Request $request;

    public function __construct() {
        $this->request = Request::capture();
    }

    protected function json(mixed $data, int $status = 200, array $headers = []): Response {
        return Response::json($data, $status, $headers);
    }

    protected function ok(mixed $data = null, string $message = 'OK'): Response {
        return Response::json(['success' => true, 'message' => $message, 'data' => $data]);
    }

    protected function created(mixed $data = null, string $message = 'Criado com sucesso.'): Response {
        return Response::json(['success' => true, 'message' => $message, 'data' => $data], 201);
    }

    protected function error(string $message, int $status = 400, array $errors = []): Response {
        $payload = ['success' => false, 'message' => $message];
        if ($errors !== []) {
            $payload['errors'] = $errors;
        }
        return Response::json($payload, $status);
    }

    /**
     * Renderiza uma view HTML envolta em um layout (app ou admin).
     */
    protected function view(string $template, array $data = [], string $layout = 'app'): Response {
        return Response::html(View::render($template, $data, $layout));
    }

    protected function redirect(string $location, int $status = 302): Response {
        return Response::redirect($location, $status);
    }

    protected function logger(): Logger {
        return Logger::instance();
    }

    protected function session(string $key, mixed $default = null): mixed {
        return Session::get($key, $default);
    }

    protected function putInSession(string $key, mixed $value): void {
        Session::set($key, $value);
    }
}
