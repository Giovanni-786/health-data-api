<?php

namespace App\Services\Filters;

use Illuminate\Support\Facades\DB;

class ConsultaFilterService
{


    public function filter($filters, $perPage)
    {

        //filtro apenas de paciente
        if(isset($filters['id_paciente']) && !isset($filters['id_medico']) && !isset($filters['id_unidade'])){
            $query = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.id as paciente_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.tipo_consulta as tipo_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->where('consulta.id_paciente', '=', $filters['id_paciente'])
                ->paginate($perPage ?? 15);

            return $query;
        }

        //filtro de paciente e medico
        if(isset($filters['id_paciente']) && isset($filters['id_medico']) && !isset($filters['id_unidade'])){
            $query = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.id as paciente_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.tipo_consulta as tipo_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->where('consulta.id_paciente', '=', $filters['id_paciente'])
                ->where('consulta.id_medico', '=', $filters['id_medico'])
                ->paginate($perPage ?? 15);

            return $query;
        }

         //filtro de paciente e unidade
         if(isset($filters['id_paciente']) && isset($filters['id_unidade']) && !isset($filters['id_medico'])){
            $query = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.id as paciente_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.tipo_consulta as tipo_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->where('consulta.id_paciente', '=', $filters['id_paciente'])
                ->where('consulta.id_unidade', '=', $filters['id_unidade'])
                ->paginate($perPage ?? 15);

            return $query;
        }

        //filtro paciente, medico e unidade
        if(isset($filters['id_unidade']) && isset($filters['id_medico']) && isset($filters['id_paciente'])){

            $query = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.id as paciente_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.tipo_consulta as tipo_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->where('consulta.id_paciente', '=', $filters['id_paciente'])
                ->where('consulta.id_medico', '=', $filters['id_medico'])
                ->where('consulta.id_unidade', '=', $filters['id_unidade'])
                ->paginate($perPage ?? 15);

                return $query;
            }


         //filtro apenas de medico
         if(isset($filters['id_medico']) && !isset($filters['id_paciente']) && !isset($filters['id_unidade'])){
            $query = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.id as paciente_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.tipo_consulta as tipo_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->where('consulta.id_medico', '=', $filters['id_medico'])
                ->paginate($perPage ?? 15);

            return $query;
        }

         //filtro medico e unidade
         if(isset($filters['id_medico']) && isset($filters['id_unidade']) && !isset($filters['id_paciente'])){
            $query = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.id as paciente_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.tipo_consulta as tipo_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->where('consulta.id_medico', '=', $filters['id_medico'])
                ->where('consulta.id_unidade', '=', $filters['id_unidade'])
                ->paginate($perPage ?? 15);

            return $query;
        }

         //filtro apenas unidade
         if(isset($filters['id_unidade']) && !isset($filters['id_paciente']) && !isset($filters['id_medico'])){
            $query = DB::table('consulta')
            ->join('paciente', 'consulta.id_paciente', '=', 'paciente.id')
            ->join('medico', 'consulta.id_medico', '=', 'medico.id')
            ->join('unidade', 'consulta.id_unidade', '=', 'unidade.id')
            ->select(
                'consulta.id as consulta_id',
                'paciente.id as paciente_id',
                'paciente.nome as paciente_nome',
                'paciente.sexo as paciente_sexo',
                'paciente.data_nascimento as paciente_data_nascimento',
                'paciente.tipo_sanguineo as paciente_tipo_sanguineo',
                'paciente.altura as paciente_altura',
                'paciente.peso as paciente_peso',
                'paciente.sexo as paciente_sexo',
                'medico.id as medico_id',
                'medico.nome as medico_nome',
                'medico.crm as medico_crm',
                'unidade.id as unidade_id',
                'unidade.nome as unidade_nome',
                'consulta.observacoes as consulta_observacoes',
                'consulta.data_consulta as data_consulta',
                'consulta.tipo_consulta as tipo_consulta',
                'consulta.created_at',
                'consulta.updated_at')
                ->where('consulta.id_unidade', '=', $filters['id_unidade'])
                ->paginate($perPage ?? 15);

            return $query;
        }

    }

}
