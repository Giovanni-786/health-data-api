<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Pessoa;
use Exception;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{


    public function indexById($id)
    {

        try {
            $findFuncionario = Funcionario::where('id', $id)->first();
            if(empty($findFuncionario)){
                return response()->json([], 200);
            }
            $id_pessoa = $findFuncionario->id_pessoa;
            $findPessoa = Pessoa::where('id', $id_pessoa)->first();
    
            return response()->json($findPessoa, 200);

        } catch (Exception $err) { 
            
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar funcionario'], 500);
        }
    }

    public function store(Request $request)
    {
        $nome = $request->get('nome');
        $nacionalidade = $request->get('nacionalidade');
        $rg = $request->get('rg');
        $data_nascimento = $request->get('data_nascimento');

        try {
            //cadastrar pessoa
            $newPessoa = new Pessoa();
            $newPessoa->nome = $nome;
            $newPessoa->nacionalidade = $nacionalidade;
            $newPessoa->rg = $rg;
            $newPessoa->data_nascimento = $data_nascimento;
            $newPessoa->save();

            $id_pessoa = $newPessoa->id;
            $newFuncionario = new Funcionario();
            $newFuncionario->id_pessoa = $id_pessoa;
            $newFuncionario->save();

            return response()->json(['data' => $newPessoa->getAttributes()], 200);
        } catch (Exception $err) {
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar o funcionário'], 500);
        }
    }
}
