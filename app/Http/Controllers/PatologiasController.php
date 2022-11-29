<?php

namespace App\Http\Controllers;

use App\Models\Patologia;
use App\Models\Patologias;
use App\Services\Filters\PatologiaFilterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatologiasController extends Controller
{
    public function __construct(PatologiaFilterService $patologiaFilterService)
    {
        $this->patologiaFilterService = $patologiaFilterService;
    }

    public function indexById(Request $request, $id){
        try{
            $findPatologia = Patologias::where('id', $id)->first();

            if(empty($findPatologia)){
                return response()->json(['Erro'=>'Patologia não encontrada'], 404);
            }

            return response()->json($findPatologia, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar patologias.'], 500);
        }
    }

    public function indexAll(Request $request){
        $perPage = $request->get('perPage');
        $filter = $request->get('filter');
        try{
            if(!empty($filter)){
                $queryFilter = $this->patologiaFilterService->filter($filter, $perPage);
                return response()->json($queryFilter, 200);
            }
            $listPatologias = DB::table('patologias')->select('id', 'nome', 'tipo', 'created_at', 'updated_at')->paginate($perPage ?? 15);
            return response()->json($listPatologias, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar patologias.'], 500);
        }
    }

    public function store(Request $request){
        $nome = $request->get('nome');
        $tipo_patologia = $request->get('tipo_patologia');

        try{
            $newPatologia = new Patologias();
            $newPatologia->nome = $nome;
            $newPatologia->tipo = $tipo_patologia;
            $newPatologia->save();

            return response()->json([
            'id' => $newPatologia->id,
            'nome' => $newPatologia->nome,
            'tipo_patologia' => $newPatologia->tipo,
            'created_at' => $newPatologia->created_at,
            'updated_at' => $newPatologia->updated_at
        ], 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar patologia'], 500);
        }
    }

    public function update(Request $request, $id){
        $nome = $request->get('nome');
        $tipo_patologia = $request->get('tipo_patologia');

        try{
            $findPatologia = Patologias::where('id', $id)->first();
            $findPatologia->nome = $nome;
            $findPatologia->tipo = $tipo_patologia;
            $findPatologia->save();

            return response()->json([
            'id' => $findPatologia->id,
            'nome' => $findPatologia->nome,
            'tipo_patologia' => $findPatologia->tipo,
            'created_at' => $findPatologia->created_at,
            'updated_at' => $findPatologia->updated_at
        ], 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar patologia'], 500);
        }
    }
}
