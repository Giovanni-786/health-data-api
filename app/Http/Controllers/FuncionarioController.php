<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Pessoa;
use App\Models\Pessoas;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuncionarioController extends Controller
{


    public function indexById($id)
    {

        try {
            $findFuncionario = Funcionario::where('id', $id)->first();
            if(empty($findFuncionario)){
                return response()->json(['Erro' => 'Funcionario não encontrado'], 404);
            }

            $id_pessoa = $findFuncionario->id_pessoa;
            $findPessoa = Pessoas::where('id', $id_pessoa)->first();
    
            return response()->json($findPessoa, 200);

        } catch (Exception $err) { 
            
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar funcionario'], 500);
        }
    }

    public function indexAll(Request $request)
    {

        try {
            //tratar para buscar funcionario de acordo com companie ou unidade
            $listFuncionario = DB::table('funcionario')
            ->select('funcionario.id', 'pessoa.nome', 'pessoa.nacionalidade', 'pessoa.rg', 'pessoa.data_nascimento', 'funcionario.created_at', 'funcionario.updated_at')
            ->join('pessoa', 'funcionario.id_pessoa', '=', 'pessoa.id')->paginate(15);
            
            if(empty($listFuncionario)){
                return response()->json([], 204);
            }
    
            return response()->json(["data"=>$listFuncionario], 200);

        } catch (Exception $err) { 
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar funcionario'], 500);
        }
    }

    public function store(Request $request)
    {
        $nome = $request->get('nome');
        $nacionalidade = $request->get('nacionalidade');
        $rg = $request->get('rg');
        $cpf = $request->get('cpf');
        $sexo = $request->get('sexo');
        $data_nascimento = $request->get('data_nascimento');

        try {
            //chamar service que vai tratar os erros
            //cadastrar pessoa
            $newPessoa = new Pessoas();
            $newPessoa->nome = $nome;
            $newPessoa->nacionalidade = $nacionalidade;
            $newPessoa->sexo = $sexo;
            $newPessoa->data_nascimento = $data_nascimento;
            $newPessoa->save();

            $id_pessoa = $newPessoa->id;
            $newFuncionario = new Funcionario();
            $newFuncionario->id_pessoa = $id_pessoa;
            $newFuncionario->rg = $rg;
            $newFuncionario->cpf = $cpf;
            $newFuncionario->save();
            return response()->json(['data' => $newPessoa->getAttributes()], 200);

        } catch (QueryException $err) {

            if($err->getCode() === '23000'){
                return response()->json(['Erro' => 'CPF ou RG já existem'], 500);
            }
            return response()->json(['Erro'=>'Ocorreu um erro inesperado ao salvar funcionario'], 500);
        }
    }
}
