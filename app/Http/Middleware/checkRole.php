<?php

namespace App\Http\Middleware;

use Closure;

class checkRole
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
        //obter o nivel de permissão dele e validar a request.
        // $user =  auth('sanctum')->user();
        // dd($user);
        return $next($request);
    }
}
