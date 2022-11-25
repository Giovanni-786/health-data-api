<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request, User $user){

        $userData = $request->only('name', 'email', 'password');


        $userData['password'] = bcrypt($userData['password']);

        if(!$user = $user->create($userData)){
            return response()->json(['Erro' => 'Registro inválido'], 400);
        }

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
