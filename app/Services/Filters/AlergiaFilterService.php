<?php

namespace App\Services\Filters;

use App\Models\Alergias;
use Illuminate\Support\Facades\DB;

class AlergiaFilterService
{


    public function filterByName($filters)
    {
        if(isset($filters['nome'])){
            $listAlergias = DB::table('alergias')
            ->where('nome', '=', $filters['nome'])
            ->orWhere('nome', 'like', '%' . $filters['nome'] . '%')
            ->paginate($perPage ?? 15);

            return $listAlergias;
        }
    }

}
