<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Pessoa;
use App\Models\Pessoas;
use App\Services\FuncionarioService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuncionarioController extends Controller
{
    public function __construct()
    {
        $this->funcionarioService = new FuncionarioService();
    }

    public function indexById($id)
    {

        try {
            $findFuncionario = Funcionario::where('id', $id)->first();
            if(empty($findFuncionario)){
                return response()->json(['Erro' => 'Funcionario não encontrado'], 404);
            }
    
            return response()->json($findFuncionario, 200);

        } catch (Exception $err) { 
            
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar funcionario'], 500);
        }
    }

    public function indexAll(Request $request)
    {
        $perPage = $request->get('perPage');

        try {
            
            $listFuncionario = DB::table('funcionario')
            ->select('funcionario.id', 'funcionario.nome', 'funcionario.nacionalidade', 'funcionario.rg', 'funcionario.data_nascimento', 'funcionario.created_at', 'funcionario.updated_at')
            ->paginate($perPage ?? 15);
            
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
        // $checkData = $this->funcionarioService->checkStore($request->all());
        // if($checkData){
        //     return response()->json($checkData->getData(), $checkData->getStatusCode());
        // }
        $nome = $request->get('nome');
        $nacionalidade = $request->get('nacionalidade');
        $rg = $request->get('rg');
        $cpf = $request->get('cpf');
        $sexo = $request->get('sexo');
        $data_nascimento = $request->get('data_nascimento');

        try {
            $newFuncionario = new Funcionario();
            $newFuncionario->nome = $nome;
            $newFuncionario->nacionalidade = $nacionalidade;
            $newFuncionario->sexo = $sexo;
            $newFuncionario->data_nascimento = $data_nascimento;
            $newFuncionario->rg = $rg;
            $newFuncionario->cpf = $cpf;
            $newFuncionario->save();
            return response()->json(['data' => $newFuncionario->getAttributes()], 200);

        } catch (QueryException $err) {
            return response()->json(['Erro'=>'Ocorreu um erro inesperado ao salvar funcionario'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $nome = $request->get('nome');
        $nacionalidade = $request->get('nacionalidade');
        $rg = $request->get('rg');
        $cpf = $request->get('cpf');
        $sexo = $request->get('sexo');
        $data_nascimento = $request->get('data_nascimento');

        try {
            $findFuncionarioById = Funcionario::where('id', $id)->first();
            if($findFuncionarioById){
                //pegar o id pessoa para atualizar/
                $findFuncionarioById->nome = $nome;
                $findFuncionarioById->nacionalidade = $nacionalidade;
                $findFuncionarioById->sexo = $sexo;
                $findFuncionarioById->data_nascimento = $data_nascimento;
                $findFuncionarioById->rg = $rg;
                $findFuncionarioById->cpf = $cpf;
                $findFuncionarioById->save();

                return response()->json(['data' => $findFuncionarioById->getAttributes()], 200);
                
            }  
            
            if(!$findFuncionarioById){
                return response()->json(['Erro' => 'Id informado não encontrado'], 404);
            }


        } catch (QueryException $err) {
            return response()->json(['Erro'=>'Ocorreu um erro inesperado ao atualizar funcionario'], 500);
        }
    }
}


