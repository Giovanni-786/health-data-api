<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Medico;
use App\Services\EspecialidadeService;
use App\Services\Filters\MedicoFilterService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    public function __construct(EspecialidadeService $especialidadeService, MedicoFilterService $medicoFilterService)
    {
        $this->especialidadeService = $especialidadeService;
        $this->medicoFilterService = $medicoFilterService;
    }

    public function indexById($id){
        try{
            $findMedico = Medico::where('id', $id)->first();
            if(empty($findMedico)){
                return response()->json(['Erro' => 'Medico não encontrada'], 404);
            }

            return response()->json($findMedico, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar medico'], 500);
        }
    }

    public function indexAll(Request $request){
        $perPage = $request->get('perPage');
        $filter = $request->get('filter');
        try{
            if(!empty($filter)){
                $queryFilter = $this->medicoFilterService->filter($filter, $perPage);
                return response()->json($queryFilter, 200);
            }

            $listMedicos = Medico::paginate($perPage ?? 15);

            if(empty($listMedicos)){
                return response()->json([], 204);
            }

            return response()->json($listMedicos, 200);

        }catch(Exception $err) {
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar medicos'], 500);
        }
    }

    public function store(Request $request){
        $nome = $request->get('nome');
        $sexo = $request->get('sexo');
        $crm = $request->get('crm');
        $dataNascimento = $request->get('data_nascimento');
        $especialidadesId = $request->get('especialidadesId');

        try{
            $this->especialidadeService->checkExistsEspecialidadeId($especialidadesId);
            $especialidades = $this->especialidadeService->findEspecialidadeAndCreateObject($especialidadesId);

            $newMedico = new Medico();
            $newMedico->nome = $nome;
            $newMedico->sexo = $sexo;
            $newMedico->crm = $crm;
            $newMedico->data_nascimento = $dataNascimento;
            $newMedico->especialidades = $especialidades;
            $newMedico->save();

            return response()->json([
                'id' => $newMedico->id,
                'nome' => $newMedico->nome,
                'sexo' => $newMedico->sexo,
                'crm' => $newMedico->crm,
                'data_nascimento' => $newMedico->data_nascimento,
                'especialidades' => $newMedico->especialidades,
                'created_at'=> $newMedico->created_at,
                'updated_at'=> $newMedico->updated_at
            ]);

        }catch(Exception $err){

            return response()->json(['Erro' => $err->getMessage()], 500);
        }
    }

    public function update(Request $request, $id){
        $nome = $request->get('nome');
        $sexo = $request->get('sexo');
        $crm = $request->get('crm');
        $dataNascimento = $request->get('data_nascimento');
        $especialidadesId = $request->get('especialidadesId');

        try{
            $findMedico = Medico::where('id', $id)->first();

            if(empty($findMedico)){
                return response()->json(['Erro' => 'Medico não encontrado'], 404);
            }

            if($findMedico){
                $this->especialidadeService->checkExistsEspecialidadeId($especialidadesId);
                $especialidades = $this->especialidadeService->findEspecialidadeAndCreateObject($especialidadesId);

                $findMedico->nome = $nome;
                $findMedico->sexo = $sexo;
                $findMedico->crm = $crm;
                $findMedico->data_nascimento = $dataNascimento;
                $findMedico->especialidades = $especialidades;
                $findMedico->save();

                return response()->json([
                    'id' => $findMedico->id,
                    'nome' => $findMedico->nome,
                    'sexo' => $findMedico->sexo,
                    'crm' => $findMedico->crm,
                    'data_nascimento' => $findMedico->data_nascimento,
                    'especialidades' => $findMedico->especialidades,
                    'created_at'=> $findMedico->created_at,
                    'updated_at'=> $findMedico->updated_at
                ]);
            }

        }catch(Exception $err){

            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar medico'], 500);
        }
    }

    public function delete($id){
        try{

            $delete = Medico::where('id', $id)->delete();
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
