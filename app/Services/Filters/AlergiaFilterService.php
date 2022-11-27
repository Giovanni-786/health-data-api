<?php

namespace App\Services\Filters;

use App\Models\Alergias;
use Illuminate\Support\Facades\DB;

class AlergiaFilterService
{


    public function filterByName($filter)
    {
        if(isset($filter['nome'])){
            $query = DB::table('alergias')
            ->where('nome', '=', $filter['nome'])
            ->orWhere('nome', 'like', '%' . $filter['nome'] . '%')
            ->paginate($perPage ?? 15);

            return $query;
        }
    }

}
