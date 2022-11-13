<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\PacienteAlergia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PacienteController extends Controller
{

    public function __construct(PacienteAlergiaController $pacienteAlergia)
    {   
        $this->pacienteAlergia = $pacienteAlergia;
    }

    public function indexAll(Request $request)
    {
        $perPage = $request->get('perPage');

        try {
            //inserir as patologias, alergias e etc.
            $listPaciente = DB::table('paciente')
            ->select(
            'paciente.id', 
            'paciente.nome', 
            'paciente.nacionalidade', 
            'paciente.data_nascimento',
            'paciente.tipo_sanguineo',
            'paciente.altura',
            'paciente.peso',
            'paciente.cpf',
            'paciente.rg',
            'paciente.created_at', 
            'paciente.updated_at')->paginate($perPage ?? 15);
            if(empty($listPaciente)){
                return response()->json([], 204);
            }
    
            return response()->json($listPaciente, 200);

        } catch (Exception $err) { 
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar paciente'], 500);
        }
    }

    public function indexById($id)
    {
        try {
            $findPaciente = Paciente::where('id', $id)->first();
            if(empty($findPaciente)){
                return response()->json([], 204);
            }

            $listPaciente = DB::table('paciente')
            ->select(
            'paciente.id', 
            'paciente.nome', 
            'paciente.nacionalidade', 
            'paciente.rg', 
            'paciente.cpf', 
            'paciente.altura',
            'paciente.peso',
            'paciente.tipo_sanguineo',
            'paciente.data_nascimento',
            'paciente.created_at', 
            'paciente.updated_at')->paginate(15);
    
            return response()->json($listPaciente, 200);

        } catch (Exception $err) { 
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar paciente'], 500);
        }
    }

    public function store(Request $request)
    {
        $nome = $request->get('nome');
        $nacionalidade = $request->get('nacionalidade');
        $rg = $request->get('rg');
        $cpf = $request->get('cpf');
        $data_nascimento = $request->get('data_nascimento');
        $sexo = $request->get('sexo');
        $tipoSanguineo = $request->get('tipo_sanguineo');
        $altura = $request->get('altura');
        $peso = $request->get('peso');
        $alergiasId = $request->get('alergiasId');

        try {
            
            //obter array de objetos das alergias e salvar no controller de paciente_alergias.
            $newPaciente = new Paciente();
            $newPaciente->nome = $nome;
            $newPaciente->nacionalidade = $nacionalidade;
            $newPaciente->data_nascimento = $data_nascimento;
            $newPaciente->sexo = $sexo;
            $newPaciente->tipo_sanguineo = $tipoSanguineo;
            $newPaciente->altura = $altura;
            $newPaciente->rg = $rg;
            $newPaciente->cpf = $cpf;
            $newPaciente->peso = $peso;
            $newPaciente->save();

            //salvar alergias
            $storeAlergias = $this->pacienteAlergia->store($alergiasId, $newPaciente->id);
            if(is_string($storeAlergias)){
                return response()->json(['Erro' => $storeAlergias], 404);
            }

            return response()->json([
            'id' => $newPaciente->id, 
            'nome' => $newPaciente->nome, 
            'nacionalidade' => $newPaciente->nacionalidade, 
            'sexo' => $newPaciente->sexo,
            'data_nascimento' => $newPaciente->data_nascimento,
            'tipo_sanguineo' => $newPaciente->tipo_sanguineo,
            'altura' => $newPaciente->altura,
            'rg' => $newPaciente->rg,
            'cpf' => $newPaciente->cpf,
            'peso' => $newPaciente->peso,
        ], 200);

        } catch (Throwable $th) {
            return response()->json($th, 400);
        }
    }

    public function update(Request $request, $id){
        $nome = $request->get('nome');
        $nacionalidade = $request->get('nacionalidade');
        $rg = $request->get('rg');
        $cpf = $request->get('cpf');
        $data_nascimento = $request->get('data_nascimento');
        $sexo = $request->get('sexo');
        $tipoSanguineo = $request->get('tipo_sanguineo');
        $altura = $request->get('altura');
        $peso = $request->get('peso');
        
        
        try{
            $findPacienteById = Paciente::where('id', $id)->first();
            if($findPacienteById){
                $findPacienteById->nome = $nome;
                $findPacienteById->nacionalidade = $nacionalidade;
                $findPacienteById->sexo = $sexo;
                $findPacienteById->data_nascimento = $data_nascimento;
                $findPacienteById->rg = $rg;
                $findPacienteById->cpf = $cpf;
                $findPacienteById->tipo_sanguineo = $tipoSanguineo;
                $findPacienteById->altura = $altura;
                $findPacienteById->peso = $peso;
                $findPacienteById->save();
                    
                return response()->json([
                'id' => $findPacienteById->id, 
                'nome' => $findPacienteById->nome,
                'nacionalidade' => $findPacienteById->nacionalidade,
                'sexo' => $findPacienteById->sexo,
                'data_nascimento'=> $findPacienteById->data_nascimento,
                'tipo_sanguineo' => $findPacienteById->tipo_sanguineo, 
                'altura' => $findPacienteById->altura,
                'peso' => $findPacienteById->peso,
                'cpf' => $findPacienteById->cpf,
                'rg' => $findPacienteById->rg,
                'created_at' => $findPacienteById->created_at,
                'updated_at' => $findPacienteById->updated_at
            ], 200);
            }
            if(!$findPacienteById){
                return response()->json(['Erro' => 'Id informado não encontrado'], 404);
            }

        }catch(Exception $err){
            dd($err);
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao atualizar paciente'], 500);
        }
    }
}
