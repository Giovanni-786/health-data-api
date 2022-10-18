<?php

namespace App\Http\Controllers;

use App\Models\Alergias;
use Exception;
use Illuminate\Http\Request;

class AlergiasController extends Controller
{
    public function store(Request $request){
        $nome = $request->get('nome');
        $tipoAlergia = $request->get('tipo_alergia');

        try{
            $newAlergia = new Alergias();
            $newAlergia->nome = $nome;
            $newAlergia->tipo = $tipoAlergia;
            $newAlergia->save();
            
            return response()->json([
                'id' => $newAlergia->id, 
                'nome' => $newAlergia->nome, 
                'tipo' => $newAlergia->tipo,
                'created_at'=> $newAlergia->created_at,
                'updated_at'=> $newAlergia->updated_at
            ]);
        }catch(Exception $err){
            if($err->getCode() === '23000'){
                return response()->json(['Erro' => 'Nome de alergia já existe'], 400);
            }
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar alergia'], 500);
        }
    }
}
