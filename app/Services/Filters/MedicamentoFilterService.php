<?php

namespace App\Services\Filters;

use App\Models\Alergias;
use Illuminate\Support\Facades\DB;

class MedicamentoFilterService
{
    public function filter($filter)
    {
        if(isset($filter['nome'])){
            $query = DB::table('medicamentos_controlados')
            ->where('nome', '=', $filter['nome'])
            ->orWhere('nome', 'like', '%' . $filter['nome'] . '%')
            ->paginate($perPage ?? 15);

            return $query;
        }
    }

}
