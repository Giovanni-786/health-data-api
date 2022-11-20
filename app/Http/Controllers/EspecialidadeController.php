<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Medico;
use Exception;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    public function indexById($id){
        try{
            $findEspecialidade = Especialidade::where('id', $id)->first();
            if(empty($findEspecialidade)){
                return response()->json(['Erro' => 'Especialidade não encontrada'], 404);
            }

            return response()->json($findEspecialidade, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar especialidades'], 500);
        }
    }

    public function indexAll(Request $request){
        $perPage = $request->get('perPage');
        try{
            $listEspecialidades = Especialidade::paginate($perPage ?? 15);

            if(empty($listEspecialidades)){
                return response()->json([], 204);
            }

            return response()->json($listEspecialidades, 200);

        }catch(Exception $err) {
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar especialidades'], 500);
        }
    }

    public function store(Request $request){
        $nome = $request->get('nome');
        try{
            $newEspecialidade = new Especialidade();
            $newEspecialidade->nome = $nome;
            $newEspecialidade->save();

            return response()->json([
                'id' => $newEspecialidade->id,
                'nome' => $newEspecialidade->nome,
                'created_at'=> $newEspecialidade->created_at,
                'updated_at'=> $newEspecialidade->updated_at
            ]);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar especialidade'], 500);
        }
    }

    public function update(Request $request, $id){
        $nome = $request->get('nome');
        try{
            $findEspecialidade = Especialidade::where('id', $id)->first();

            if(empty($findEspecialidade)){
                return response()->json(['Erro' => 'Especialidade não encontrada'], 404);
            }

            if($findEspecialidade){
                $findEspecialidade->nome = $nome;
                $findEspecialidade->save();

                return response()->json([
                    'id' => $findEspecialidade->id,
                    'nome' => $findEspecialidade->nome,
                    'created_at'=> $findEspecialidade->created_at,
                    'updated_at'=> $findEspecialidade->updated_at
                ]);
            }
        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar especialidade'], 500);
        }
    }
}
