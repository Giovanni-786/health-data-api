<?php

namespace App\Http\Controllers;

use App\Models\Patologia;
use App\Models\Patologias;
use Exception;
use Illuminate\Http\Request;

class PatologiasController extends Controller
{
    public function store(Request $request){
        //obter informação e salvar no banco
        $nome = $request->get('nome');

        try{
            $newPatologia = new Patologias();
            $newPatologia->nome = $nome;
            $newPatologia->save();

            return response()->json([
            'id' => $newPatologia->id, 
            'nome' => $newPatologia->nome, 
            'created_at' => $newPatologia->created_at,
            'updated_at' => $newPatologia->updated_at
        ], 200);

        }catch(Exception $err){
            if($err->getCode() === '23000'){
                return response()->json(['Erro' => 'Nome já existe'], 400);
            }
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar patologia'], 500);
        }
    }
}
