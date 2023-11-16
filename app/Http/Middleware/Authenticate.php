<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!auth()->check()) {
            // User is not authenticated, you can handle it as needed
            //abort(403, 'Você não esta autorizado a acessar esta rota. Por favor, faça login.');
            return response()->json(['status' => 401, "message" => 'Acao nao autorizada.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // User is authenticated, allow the request to proceed
        return parent::handle($request, $next, ...$guards);
    }
}
