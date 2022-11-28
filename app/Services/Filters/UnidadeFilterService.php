<?php

namespace App\Services\Filters;

use App\Models\Alergias;
use Illuminate\Support\Facades\DB;

class UnidadeFilterService
{
    public function filter($filter, $perPage)
    {
        //apenas nome
        if(isset($filter['nome']) && !isset($filter['nome'])){
            $query = DB::table('unidade')
            ->where('nome', '=', $filter['nome'])
            ->orWhere('nome', 'like', '%' . $filter['nome'] . '%')
            ->paginate($perPage ?? 15);

            return $query;
        }
        //nome e cnpj
        if(isset($filter['nome']) && isset($filter['cnpj'])){
            $query = DB::table('unidade')
            ->where('nome', 'like', '%' . $filter['nome'] . '%')
            ->where('cnpj', '=', $filter['cnpj'])
            ->paginate($perPage ?? 15);

            return $query;
        }
        //apenas cnpj
        if(isset($filter['cnpj']) && !isset($filter['nome'])){
            $query = DB::table('unidade')
            ->where('cnpj', '=', $filter['cnpj'])
            ->paginate($perPage ?? 15);
            return $query;
        }
    }

}
