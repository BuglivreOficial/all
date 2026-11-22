<?php
namespace Core\Routing;

use Core\Http\Request;

interface MiddlewareInterface {
    /**
     * Executa o middleware. Chame $next() para seguir; devolva um Response para interromper.
     */
    public function handle(Request $request, callable $next): mixed;
}
