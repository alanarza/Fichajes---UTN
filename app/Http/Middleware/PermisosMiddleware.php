<?php

namespace App\Http\Middleware;

use Closure;

class PermisosMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->permisos != 1) {
            return redirect('/')->with('codigo', '3')->with('status', 'No tienes permiso de administrador para acceder a esta pagina.');
        }

        return $next($request);
    }
}
