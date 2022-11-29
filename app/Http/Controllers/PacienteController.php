<?php

namespace App\Http\Controllers;

use App\Models\Alergias;
use App\Models\Paciente;
use App\Models\PacienteAlergia;
use App\Services\AlergiaService;
use App\Services\Filters\PacienteFilterService;
use App\Services\MedicamentoService;
use App\Services\PatologiaService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class PacienteController extends Controller
{

    public function __construct(AlergiaService $alergiaService, MedicamentoService $medicamentoService, PatologiaService $patologiaService, PacienteFilterService $pacienteFilterService)
    {
        $this->alergiaService = $alergiaService;
        $this->medicamentoService = $medicamentoService;
        $this->patologiaService = $patologiaService;
        $this->pacienteFilterService = $pacienteFilterService;
    }

    public function indexAll(Request $request)
    {

        $perPage = $request->get('perPage');
        $filter = $request->get('filter');
        try {
            if(!empty($filter)){
                $queryFilter = $this->pacienteFilterService->filter($filter, $perPage);
                return response()->json($queryFilter, 200);
            }

            $listPaciente = Paciente::paginate($perPage ?? 15);

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

            return response()->json($findPaciente, 200);

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
        $medicamentosId = $request->get('medicamentosId');
        $patologiasId = $request->get('patologiasId');

        try {
            $this->alergiaService->checkExistsAlergiasId($alergiasId);
            $this->medicamentoService->checkExistsMedicamentoId($medicamentosId);
            $this->patologiaService->checkExistsPatologiaId($patologiasId);

            $alergias = $this->alergiaService->findAlergiasAndCreateObject($alergiasId);
            $medicamentos = $this->medicamentoService->findMedicamentosAndCreateObject($medicamentosId);
            $patologias = $this->patologiaService->findPatologiasAndCreateObject($patologiasId);

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
            $newPaciente->alergias = $alergias;
            $newPaciente->medicamentos = $medicamentos;
            $newPaciente->patologias = $patologias;
            $newPaciente->save();

            return response()->json([
                "id" => $newPaciente->id,
                "nome" => $newPaciente->nome,
                "nacionalidade" => $newPaciente->nacionalidade,
                "data_nascimento" => $newPaciente->data_nascimento,
                "sexo" => $newPaciente->sexo,
                "tipo_sanguineo" => $newPaciente->tipo_sanguineo,
                "altura" => $newPaciente->altura,
                "rg" => $newPaciente->rg,
                "cpf" => $newPaciente->cpf,
                "peso" => $newPaciente->peso,
                "alergias" => $newPaciente->alergias,
                "medicamentos" => $newPaciente->medicamentos,
                "patologias" => $newPaciente->patologias
        ], 201);

        } catch (\Throwable $th) {
            return response()->json(['Erro' => $th->getMessage()], 500);
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
        $alergiasId = $request->get('alergiasId');
        $medicamentosId = $request->get('medicamentosId');
        $patologiasId = $request->get('patologiasId');

        try{
            $findPacienteById = Paciente::where('id', $id)->first();
            if($findPacienteById){
                $this->alergiaService->checkExistsAlergiasId($alergiasId);
                $this->medicamentoService->checkExistsMedicamentoId($medicamentosId);
                $this->patologiaService->checkExistsPatologiaId($patologiasId);

                $alergias = $this->alergiaService->findAlergiasAndCreateObject($alergiasId);
                $medicamentos = $this->medicamentoService->findMedicamentosAndCreateObject($medicamentosId);
                $patologias = $this->patologiaService->findPatologiasAndCreateObject($patologiasId);

                $findPacienteById->nome = $nome;
                $findPacienteById->nacionalidade = $nacionalidade;
                $findPacienteById->sexo = $sexo;
                $findPacienteById->data_nascimento = $data_nascimento;
                $findPacienteById->rg = $rg;
                $findPacienteById->cpf = $cpf;
                $findPacienteById->tipo_sanguineo = $tipoSanguineo;
                $findPacienteById->altura = $altura;
                $findPacienteById->peso = $peso;
                $findPacienteById->alergias = $alergias;
                $findPacienteById->medicamentos = $medicamentos;
                $findPacienteById->patologias = $patologias;
                $findPacienteById->save();

                return response()->json([
                    $findPacienteById
            ], 200);
            }

            if(!$findPacienteById){
                return response()->json(['Erro' => 'Id paciente informado não encontrado'], 404);
            }

        }catch(\Throwable $th){
            return response()->json(['Erro' => $th->getMessage()], $th->getCode());
        }
    }

    public function delete($id){
        try{
            $delete = Paciente::where('id', $id)->delete();
            if($delete == 1){
                return response()->json(['data'=>'registro excluído com sucesso'], 204);
            }
            if($delete == 0){
                return response()->json(['data'=>'registro não encontrado'], 404);
            }
        }catch(QueryException $err){
            return response()->json(['data'=>'ocorreu um erro inesperado ao excluir registro'], 500);
        }
    }
}
