<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Pessoa;
use Exception;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
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
            $newPessoa = new Pessoa();
            $newPessoa->nome = $nome;
            $newPessoa->nacionalidade = $nacionalidade;
            $newPessoa->sexo = $sexo;
            $newPessoa->data_nascimento = $data_nascimento;
            $newPessoa->save();
            $id_pessoa = $newPessoa->id;
            
            $newPaciente = new Paciente();
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

            if($err->getCode() === '23000'){
                return response()->json(['Erro' => 'CPF ou RG já existem'], 500);
            }
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar paciente'], 500);
        }
    }
}
