<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Pacientes;
use App\Models\Pessoa;
use App\Models\Pessoas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{

    public function indexAll(Request $request)
    {

        try {
            //inserir as patologias, alergias e etc.
            $listPaciente = DB::table('paciente')
            ->select(
            'paciente.id', 
            'pessoa.nome', 
            'pessoa.nacionalidade', 
            'pessoa.data_nascimento',
            'paciente.tipo_sanguineo',
            'paciente.altura',
            'paciente.peso',
            'paciente.cpf',
            'paciente.rg',
            'paciente.created_at', 
            'paciente.updated_at')
            ->join('pessoa', 'paciente.id_pessoa', '=', 'pessoa.id')->paginate(15);
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
            $findPaciente = Pacientes::where('id', $id)->first();
            if(empty($findPaceinte)){
                return response()->json([], 204);
            }

            $listFuncionario = DB::table('paciente')
            ->select(
            'paciente.id', 
            'pessoa.nome', 
            'pessoa.nacionalidade', 
            'paciente.rg', 
            'paciente.cpf', 
            'paciente.altura',
            'paciente.peso',
            'paciente.tipo_sanguineo',
            'paciente.id_patologias',
            'paciente.id_alergias',
            'paciente.id_medicamentos_controlados',
            'pessoa.data_nascimento',
            'paciente.created_at', 
            'paciente.updated_at')
            ->join('pessoa', 'paciente.id_pessoa', '=', 'pessoa.id')->paginate(15);
    
            return response()->json($listFuncionario, 200);

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
        $idPatologia = $request->get('id_patologia');
        $idAlergia = $request->get('id_alergia');
        $idMedicamentosControlados = $request->get('id_medicamento_controlado');
        
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
            
            $newPaciente = new Pacientes();
            $newPaciente->id_pessoa = $id_pessoa;
            $newPaciente->tipo_sanguineo = $tipoSanguineo;
            $newPaciente->altura = $altura;
            $newPaciente->rg = $rg;
            $newPaciente->cpf = $cpf;
            $newPaciente->peso = $peso;
            $newPaciente->id_patologias = $idPatologia;
            $newPaciente->id_alergias = $idAlergia;
            $newPaciente->id_medicamentos_controlados = $idMedicamentosControlados;
            $newPaciente->save();

            return response()->json([
            'id' => $newPaciente->id, 
            'nome' => $newPessoa->nome, 
            'nacionalidade' => $newPessoa->nacionalidade, 
            'sexo' => $newPessoa->sexo,
            'data_nascimento' => $newPessoa->data_nascimento,
            'tipo_sanguineo' => $newPaciente->tipo_sanguineo,
            'altura' => $newPaciente->altura,
            'rg' => $newPaciente->rg,
            'cpf' => $newPaciente->cpf,
            'peso' => $newPaciente->peso,
            'patologia_id' => $newPaciente->id_patologia,
            'alergia_id' => $newPaciente->id_alergia,
            'medicamentos_controlados_id' => $newPaciente->id_medicamentos_controlados
        ], 200);

        } catch (Exception $err) {

            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar paciente'], 500);
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
        $idPatologia = $request->get('id_patologia');
        $idAlergia = $request->get('id_alergia');
        $idMedicamentosControlados = $request->get('id_medicamento_controlado');
        
        try{
            $findPacienteById = Pacientes::where('id', $id)->first();
            if($findPacienteById){
                $findPessoaById = Pessoas::where('id', $findPacienteById->id_pessoa)->first();
                if($findPessoaById){
                    
                    $findPessoaById->nome = $nome;
                    $findPessoaById->nacionalidade = $nacionalidade;
                    $findPessoaById->sexo = $sexo;
                    $findPessoaById->data_nascimento = $data_nascimento;
                    $findPessoaById->save();

                    $findPacienteById->rg = $rg;
                    $findPacienteById->cpf = $cpf;
                    $findPacienteById->tipo_sanguineo = $tipoSanguineo;
                    $findPacienteById->altura = $altura;
                    $findPacienteById->peso = $peso;
                    $findPacienteById->id_pessoa = $findPacienteById->id_pessoa;
                    $findPacienteById->id_patologias = $idPatologia;
                    $findPacienteById->id_alergias = $idAlergia;
                    $findPacienteById->id_medicamentos_controlados = $idMedicamentosControlados;
                    $findPacienteById->save();
                    
                    return response()->json([
                    'id' => $findPacienteById->id, 
                    'nome' => $findPessoaById->nome,
                    'nacionalidade' => $findPessoaById->nacionalidade,
                    'sexo' => $findPessoaById->sexo,
                    'data_nascimento'=> $findPessoaById->data_nascimento,
                    'tipo_sanguineo' => $findPacienteById->tipo_sanguineo, 
                    'altura' => $findPacienteById->altura,
                    'peso' => $findPacienteById->peso,
                    'cpf' => $findPacienteById->cpf,
                    'rg' => $findPacienteById->rg,
                    'created_at' => $findPacienteById->created_at,
                    'updated_at' => $findPacienteById->updated_at
                ], 200);
                }
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
