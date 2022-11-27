<?php

namespace App\Http\Controllers;

use App\Models\Alergias;
use App\Services\Filters\AlergiaFilterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlergiasController extends Controller
{
    public function __construct(AlergiaFilterService $alergiaFilterService)
    {
        $this->alergiaFilterService = $alergiaFilterService;
    }

    public function indexById($id){
        try{
            $findAlergia = Alergias::where('id', $id)->first();
            if(empty($findAlergia)){
                return response()->json(['Erro' => 'Alergia não encontrada'], 404);
            }

            return response()->json($findAlergia, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar alergia'], 500);
        }
    }

    public function indexAll(Request $request){
        $perPage = $request->get('perPage');
        $filter = $request->get('filter');

        try{
            if(!empty($filter)){

               $queryFilter = $this->alergiaFilterService->filterByName($filter);
                return response()->json($queryFilter, 200);
            }

            $listAlergias = DB::table('alergias')
            ->select('alergias.id', 'alergias.nome', 'alergias.tipo', 'alergias.created_at', 'alergias.updated_at')
            ->paginate($perPage ?? 15);

            if(empty($listAlergias)){
                return response()->json([], 204);
            }

            return response()->json($listAlergias, 200);

        }catch(Exception $err) {
            return response()->json(['Erro' => 'ocorreu um erro inesperado ao listar alergias'], 500);
        }
    }

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

            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar alergia'], 500);
        }
    }

    public function update(Request $request, $id){
        $nome = $request->get('nome');
        $tipoAlergia = $request->get('tipo_alergia');
        try{
            $findAlergia = Alergias::where('id', $id)->first();

            if(empty($findAlergia)){
                return response()->json(['Erro' => 'Alergia não encontrada'], 404);
            }

            if($findAlergia){
                $findAlergia->nome = $nome;
                $findAlergia->tipo = $tipoAlergia;
                $findAlergia->save();

                return response()->json([
                    'id' => $findAlergia->id,
                    'nome' => $findAlergia->nome,
                    'tipo' => $findAlergia->tipo,
                    'created_at'=> $findAlergia->created_at,
                    'updated_at'=> $findAlergia->updated_at
                ]);
            }

        }catch(Exception $err){

            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar alergia'], 500);
        }
    }
}
