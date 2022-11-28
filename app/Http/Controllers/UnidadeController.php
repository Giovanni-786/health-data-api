<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Services\Filters\UnidadeFilterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
{
    public function __construct(UnidadeFilterService $unidadeFilterService)
    {
        $this->unidadeFilterService = $unidadeFilterService;
    }

    public function indexById(Request $request, $id){
        try{
            $findUnidade = Unidade::where('id', $id)->first();

            if(empty($findUnidade)){
                return response()->json(['Erro' => 'Unidade não encontrada'], 404);
            }

            return response()->json($findUnidade, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar unidade.'], 500);
        }
    }

    public function indexAll(Request $request){
        $perPage = $request->get('perPage');
        $filter = $request->get('filter');
        try{
            if(!empty($filter)){
                $queryFilter = $this->unidadeFilterService->filter($filter, $perPage);
                return response()->json($queryFilter, 200);
            }
            $listUnidade = DB::table('unidade')
            ->select(
                'nome',
                'razao_social',
                'cnpj',
                'created_at',
                'updated_at')
                ->paginate($perPage ?? 15);

            return response()->json($listUnidade, 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao listar unidade.'], 500);
        }
    }

    public function store(Request $request){
        $nome = $request->get('nome');
        $razaoSocial = $request->get('razao_social');
        $cnpj = $request->get('cnpj');

        try{
            $newUnidade = new Unidade();
            $newUnidade->nome = $nome;
            $newUnidade->razao_social = $razaoSocial;
            $newUnidade->cnpj = $cnpj;
            $newUnidade->save();

            return response()->json([
                $newUnidade->getAttributes()
        ], 200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar unidade'], 500);
        }
    }

    public function update(Request $request, $id){
        $nome = $request->get('nome');
        $razaoSocial = $request->get('razao_social');
        $cnpj = $request->get('cnpj');
        try{
            $findUnidade = Unidade::where('id', $id)->first();
            if(empty($findUnidade)){
                return response()->json(['Erro' => 'patologia não encontrada'], 404);
            }

            $findUnidade->nome = $nome;
            $findUnidade->razao_social = $razaoSocial;
            $findUnidade->cnpj = $cnpj;
            $findUnidade->save();

            return response()->json($findUnidade->getAttributes() ,200);

        }catch(Exception $err){
            return response()->json(['Erro' => 'Ocorreu um erro inesperado ao salvar unidade'], 500);
        }
    }
}
