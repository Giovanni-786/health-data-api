<?php

namespace App\Http\Controllers;

use App\Models\Medicamentos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicamentosController extends Controller
{
    public function indexById(Request $request, $id){
        try{
            $findMedicamento = Medicamentos::where('id', $id)->first();

            if(empty($findMedicamento)){
                return response()->json(['Erro' => 'Medicamento não encontrado'], 404);
            }

            return response()->json($findMedicamento, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar medicamento.'], 500);
        }
    }

    public function indexAll(Request $request){
        $perPage = $request->get('perPage');
        try{
            $listMedicamentos = DB::table('medicamentos_controlados')
            ->select('nome', 'dosagem', 'unidade_medida', 'created_at', 'updated_at')
            ->paginate($perPage ?? 15);
            return response()->json($listMedicamentos, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar medicamentos.'], 500);
        }
    }

    public function store(Request $request){
        $nome = $request->get('nome');
        $dosagem = $request->get('dosagem');
        $unidade_medida = $request->get('unidade_medida');
    
        try{
            $newMedicamento = new Medicamentos();
            $newMedicamento->nome = $nome;
            $newMedicamento->dosagem = $dosagem;
            $newMedicamento->unidade_medida = $unidade_medida;
            $newMedicamento->save();

            return response()->json([
            'id' => $newMedicamento->id, 
            'nome' => $newMedicamento->nome, 
            'dosagem' => $newMedicamento->dosagem,
            'unidade_medida' => $newMedicamento->unidade_medida, 
            'created_at' => $newMedicamento->created_at,
            'updated_at' => $newMedicamento->updated_at
        ], 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar medicamento'], 500);
        }
    }

    public function update(Request $request, $id){
        $nome = $request->get('nome');
        $dosagem = $request->get('dosagem');
        $unidade_medida = $request->get('unidade_medida');
    
        try{
            $findMedicamento = Medicamentos::where('id', $id)->first();
            $findMedicamento->nome = $nome;
            $findMedicamento->dosagem = $dosagem;
            $findMedicamento->unidade_medida = $unidade_medida;
            $findMedicamento->save();

            return response()->json([
            'id' => $findMedicamento->id, 
            'nome' => $findMedicamento->nome, 
            'dosagem' => $findMedicamento->dosagem,
            'unidade_medida' => $findMedicamento->unidade_medida, 
            'created_at' => $findMedicamento->created_at,
            'updated_at' => $findMedicamento->updated_at
        ], 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar medicamento'], 500);
        }
    }
}
