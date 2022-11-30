<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexAll(Request $request){
        try{
            $user =  auth('sanctum')->user();
            if($user->id_unidade){
                $listUsersByUnidade = User::where('id_unidade', $user->id_unidade)->select('id', 'name', 'email', 'cargo', 'id_unidade', 'created_at', 'updated_at')->get();
                return response()->json($listUsersByUnidade, 200);
            }else{
                return response()->json($user, 200);
            }
        }catch(Exception $err){
            return response()->json(['data' => 'Ocorreu um erro inesperado ao listar usuários'], 500);
        }

    }
}
