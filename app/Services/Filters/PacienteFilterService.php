<?php

namespace App\Services\Filters;

use App\Models\Alergias;
use App\Models\Paciente;
use Illuminate\Support\Facades\DB;

class PacienteFilterService
{


    public function filter($filter)
    {

        //apenas por nome
        if(isset($filter['nome']) && !isset($filter['rg']) && !isset($filter['cpf'])){
            $query = Paciente::where('nome', 'like', '%' . $filter['nome'] . '%')
            ->paginate($perPage ?? 15);
            return $query;
        }

        //nome e rg
        if(isset($filter['nome']) && isset($filter['rg']) && !isset($filter['cpf'])){
            $query = Paciente::where('nome', 'like', '%' . $filter['nome'] . '%')
            ->where('rg', '=', $filter['rg'])
            ->paginate($perPage ?? 15);
            return $query;
        }

        //nome, rg e cpf
        if(isset($filter['nome']) && isset($filter['rg']) && isset($filter['cpf'])){
            $query = Paciente::where('nome', 'like', '%' . $filter['nome'] . '%')
            ->where('rg', '=', $filter['rg'])
            ->where('cpf', '=', $filter['cpf'])
            ->paginate($perPage ?? 15);
            return $query;
        }

        //apenas rg
        if(isset($filter['rg']) && !isset($filter['cpf']) && !isset($filter['nome'])){
            $query = Paciente::where('rg', '=', $filter['rg'])
            ->paginate($perPage ?? 15);
            return $query;
        }

        //apenas cpf
        if(isset($filter['cpf']) && !isset($filter['rg']) && !isset($filter['nome'])){
            $query = Paciente::where('cpf', '=', $filter['cpf'])
            ->paginate($perPage ?? 15);
            return $query;
        }
    }

}
