<?php

namespace App\Services\Filters;

use App\Models\Alergias;
use App\Models\Medico;
use Illuminate\Support\Facades\DB;

class MedicoFilterService
{

    public function filter($filter, $perPage)
    {

        //apenas por nome
        if(isset($filter['nome']) && !isset($filter['crm'])){
            $query =  Medico::where('nome', '=', $filter['nome'])
            ->orWhere('nome', 'like', '%' . $filter['nome'] . '%')
            ->paginate($perPage ?? 15);
            return $query;
        }
        //nome e crm
        if(isset($filter['nome']) && isset($filter['crm'])){
            $query =  Medico::where('nome', 'like', '%' . $filter['nome'] . '%')
            ->where('crm', '=', $filter['crm'])
            ->paginate($perPage ?? 15);
            return $query;
        }

        //apenas crm
        if(isset($filter['crm']) && !isset($filter['nome'])){
            $query =  Medico::where('crm', '=', $filter['crm'])
            ->paginate($perPage ?? 15);
            return $query;
        }
    }

}
