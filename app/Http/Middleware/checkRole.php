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
        //se o cargo for medico, validar as requests
        $user =  auth('sanctum')->user();

        if($user->is_admin){
            return $next($request);
        }

        if($user->cargo == 'medico'){
            if($request->getPathInfo() == '/api/alergias' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }
            if($request->getPathInfo() == '/api/auth/register' ){
                return response()->json(['data'=>'não autorizado'], 403);
            }
            if($request->getPathInfo() == '/api/medicos' ){
                if($request->getMethod() == 'DELETE'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }
            if($request->getPathInfo() == '/api/especialidades' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }
            if($request->getPathInfo() == '/api/medicamentos'){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }

            if($request->getPathInfo() == '/api/patologias'){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }

            if($request->getPathInfo() == '/api/unidades' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }

            if($request->getPathInfo() == '/api/unidades' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }
        }

        if($user->cargo == 'assistente'){
            if($request->getPathInfo() == '/api/auth/register' ){
                return response()->json(['data'=>'não autorizado'], 403);
            }

            if($request->getPathInfo() == '/api/alergias' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }
            if($request->getPathInfo() == '/api/medicos' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }
            if($request->getPathInfo() == '/api/especialidades' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }
            if($request->getPathInfo() == '/api/medicamentos' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }

            if($request->getPathInfo() == '/api/patologias' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }

            if($request->getPathInfo() == '/api/consultas' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }

            if($request->getPathInfo() == '/api/pacientes' ){
                if($request->getMethod() == 'DELETE'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }

            if($request->getPathInfo() == '/api/user' ){
                if($request->getMethod() != 'GET'){
                    return response()->json(['data'=>'não autorizado'], 403);
                }
            }

        }

        return $next($request);
    }
}
