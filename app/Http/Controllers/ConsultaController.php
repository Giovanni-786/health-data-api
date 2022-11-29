<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Services\ConsultaService;
use App\Services\Filters\ConsultaFilterService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public function __construct(ConsultaService $consultaService, ConsultaFilterService $consultaFilterService)
    {
        $this->consultaService = $consultaService;
        $this->consultaFilterService = $consultaFilterService;
    }
    public function indexById(Request $request, $id){
        try{
            //fazer inner join
            $findConsulta = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->where('consulta.id', $id)->first();

            if(empty($findConsulta)){
                return response()->json(['Erro' => 'Consulta não encontrada'], 404);
            }

            return response()->json($findConsulta, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar consulta.'], 500);
        }
    }

    public function indexAll(Request $request){
        $perPage = $request->get('perPage');
        $filter = $request->get('filter');

        try{

            if(!empty($filter)){
                $queryFilter = $this->consultaFilterService->filter($filter, $perPage);
                 return response()->json($queryFilter, 200);
             }

            $listConsulta = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->paginate($perPage ?? 15);


            return response()->json($listConsulta, 200);

        }catch(Exception $err){

            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar consulta.'], 500);
        }
    }

    public function store(Request $request){
        $idPaciente = $request->get('id_paciente');
        $idMedico = $request->get('id_medico');
        $idUnidade = $request->get('id_unidade');
        $dataConsulta = $request->get('data_consulta');
        $tipoConsulta = $request->get('tipo_consulta');
        $observacoes = $request->get('observacoes');

        try{
            $newConsulta = new Consulta();
            $newConsulta->id_paciente = $idPaciente;
            $newConsulta->id_medico = $idMedico;
            $newConsulta->id_unidade = $idUnidade;
            $newConsulta->data_consulta = $dataConsulta;
            $newConsulta->tipo_consulta = $tipoConsulta;
            $newConsulta->observacoes = $observacoes;
            $newConsulta->save();

            return response()->json([
                $newConsulta->getAttributes()
        ], 200);

        }catch(Exception $err){

            return response()->json(['Erro' => $err->getMessage()], 500);
        }
    }

    public function update(Request $request, $id){
        $idPaciente = $request->get('id_paciente');
        $idMedico = $request->get('id_medico');
        $idUnidade = $request->get('id_unidade');
        $dataConsulta = $request->get('data_consulta');
        $tipoConsulta = $request->get('tipo_consulta');
        $observacoes = $request->get('observacoes');

        try{
            $findConsulta = Consulta::where('id', $id)->first();
            if(empty($findConsulta)){
                return response()->json(['Erro' => 'consulta não encontrada'], 404);
            }

            $findConsulta->id_paciente = $idPaciente;
            $findConsulta->id_medico = $idMedico;
            $findConsulta->id_unidade = $idUnidade;
            $findConsulta->data_consulta = $dataConsulta;
            $findConsulta->tipo_consulta = $tipoConsulta;
            $findConsulta->observacoes = $observacoes;
            $findConsulta->save();

            return response()->json($findConsulta->getAttributes() ,200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar consulta'], 500);
        }
    }

    public function delete($id){
        try{
            $delete = Consulta::where('id', $id)->delete();
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
