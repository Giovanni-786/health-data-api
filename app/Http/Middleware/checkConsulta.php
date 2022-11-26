<?php

namespace App\Http\Middleware;

use Closure;

class checkConsulta
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
        $user =  auth('sanctum')->user();
        //se for super admin, autoriza.
        if($user->is_admin){
            return $next($request);
        }
        //verificar se o id passado é igual ao id_medico da tabela do usuário.
        if($request->get('id_medico') != $user->id_medico){
            return response()->json(['403' => 'não autorizado'], 403);
        }

        return $next($request);
    }
}
