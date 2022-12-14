<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Medico;
use App\Services\Filters\EspecialidadeFilterService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    public function __construct(EspecialidadeFilterService $especialidadeFilterService)
    {
        $this->especialidadeFilterService = $especialidadeFilterService;
    }

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
        $filter = $request->get('filter');

        try{
            if(!empty($filter)){
                $queryFilter = $this->especialidadeFilterService->filter($filter);
                return response()->json($queryFilter, 200);
             }
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
    public function delete($id){
        try{
            $delete = Especialidade::where('id', $id)->delete();
            if($delete == 1){
                return response()->json(['data'=>'registro excluído com sucesso'], 204);
            }
            if($delete == 0){
                return response()->json(['data'=>'registro não encontrado'], 404);
            }
        }catch(QueryException $err){
            return response()->json(['data'=>'ocorreu um erro inesperado ao excluir registro'], 500);
        }
    }
}
