<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Services\EspecialidadeService;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class RegisterController extends Controller
{
    public function __construct(EspecialidadeService $especialidadeService)
    {
        $this->especialidadeService = $especialidadeService;
    }
    public function register(Request $request){
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $cargo = $request->get('cargo');
        $id_medico = $request->get('id_medico');

        try{
            //caso for medico, id_medico é obrigatório.
            if($cargo == 'medico'){
                if(empty($id_medico)){
                    return response()->json(['Erro' => 'campo id_medico é obrigatório'], 400);
                }
            }

            $password = bcrypt($password);

            $createUser = new User();
            $createUser->name = $name;
            $createUser->email = $email;
            $createUser->password = $password;
            $createUser->cargo = $cargo;
            $createUser->id_medico = $id_medico;
            $createUser->save();

            return response()->json([
                'data' => [
                    'user' => $createUser
                ]
            ]);

        }catch(QueryException $err){
            dd($err);
            if(isset($err->errorInfo[2]) &&  $err->errorInfo[2] == "Data truncated for column 'cargo' at row 1"){
                return response()->json(['erro'=>"cargo aceita apenas os valores: 'medico', 'assistente', 'atendente'"], 400);
            }

            return response()->json(['erro'=> "erro inesperado ao criar usuário"], 500);
        }

    }
}
