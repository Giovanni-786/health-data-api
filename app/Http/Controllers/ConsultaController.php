<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public function indexById(Request $request, $id){
        try{
            //fazer inner join
            $findConsulta = Consulta::where('id', $id)->first();

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
        try{
            //FAZER INNER JOIN
            $listConsulta = DB::table('consulta')
            ->select(
                'id_paciente',
                'id_medico',
                'id_unidade',
                'data_consulta',
                'created_at',
                'updated_at')
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
}
