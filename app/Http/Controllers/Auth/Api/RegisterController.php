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
    public function register(Request $request, User $user){

        // $userData = $request->only('name', 'email', 'password', 'cargo', 'crm', 'especialidades');
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $cargo = $request->get('cargo');
        $crm = $request->get('crm');
        $especialidadesId = $request->get('especialidadesId');

        try{

            //caso for medico, crm é obrigatório.
            if($cargo == 'medico'){
                if(empty($crm)){
                    return response()->json(['Erro' => 'campo CRM é obrigatório'], 400);
                }
            }

            $password = bcrypt($password);

            $this->especialidadeService->checkExistsEspecialidadeId($especialidadesId);
            $especialidades = $this->especialidadeService->findEspecialidadeAndCreateObject($especialidadesId);

            $createUser = new User();
            $createUser->name = $name;
            $createUser->email = $email;
            $createUser->password = $password;
            $createUser->cargo = $cargo;
            $createUser->crm = $crm;
            $createUser->especialidades = $especialidades;
            $createUser->save();



            return response()->json([
                'data' => [
                    'user' => $createUser
                ]
            ]);
        }catch(QueryException $err){
            if($err->errorInfo[2] == "Data truncated for column 'cargo' at row 1"){
                return response()->json(['erro'=>"cargo aceita apenas os valores: 'medico', 'assistente', 'atendente'"], 400);
            }
        }

        // if(!$user = $user->create($userData)){
        //     return response()->json(['Erro' => 'Registro inválido'], 400);
        // }


    }
}
