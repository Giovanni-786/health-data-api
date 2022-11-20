<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Medico;
use App\Services\EspecialidadeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    public function __construct(EspecialidadeService $especialidadeService)
    {
        $this->especialidadeService = $especialidadeService;
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
        try{
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
            dd($err);
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar medico'], 500);
        }
    }

    // public function update(Request $request, $id){
    //     $nome = $request->get('nome');
    //     $tipoAlergia = $request->get('tipo_alergia');
    //     try{
    //         $findAlergia = Alergias::where('id', $id)->first();

    //         if(empty($findAlergia)){
    //             return response()->json(['Erro' => 'Alergia não encontrada'], 404);
    //         }

    //         if($findAlergia){
    //             $findAlergia->nome = $nome;
    //             $findAlergia->tipo = $tipoAlergia;
    //             $findAlergia->save();

    //             return response()->json([
    //                 'id' => $findAlergia->id,
    //                 'nome' => $findAlergia->nome,
    //                 'tipo' => $findAlergia->tipo,
    //                 'created_at'=> $findAlergia->created_at,
    //                 'updated_at'=> $findAlergia->updated_at
    //             ]);
    //         }

    //     }catch(Exception $err){

    //         return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar alergia'], 500);
    //     }
    // }
}
