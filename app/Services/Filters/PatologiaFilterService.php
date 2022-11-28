<?php

namespace App\Services\Filters;

use Illuminate\Support\Facades\DB;

class PatologiaFilterService
{

    public function filter($filter, $perPage)
    {
        if(isset($filter['nome']) && !isset($filter['tipo'])){
            $query = DB::table('patologias')
            ->where('nome', '=', $filter['nome'])
            ->orWhere('nome', 'like', '%' . $filter['nome'] . '%')
            ->paginate($perPage ?? 15);
            return $query;
        }

        if(isset($filter['nome']) && isset($filter['tipo'])){
            $query = DB::table('patologias')
            ->where('nome', '=', $filter['nome'])
            ->orWhere('nome', 'like', '%' . $filter['nome'] . '%')
            ->where('tipo', '=', $filter['tipo'])
            ->paginate($perPage ?? 15);
            return $query;
        }

        if(isset($filter['tipo']) && !isset($filter['nome'])){
            $query = DB::table('patologias')
            ->where('tipo', '=', $filter['tipo'])
            ->paginate($perPage ?? 15);
            return $query;
        }
    }

}
