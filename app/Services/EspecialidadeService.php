<?php

namespace App\Services;

use App\Models\Especialidade;


class EspecialidadeService
{

    public function checkExistsEspecialidadeId($ids)
    {

        if(!empty($ids)){
            foreach($ids as $id){
                $find = Especialidade::where('id', $id)->first();
                if(!$find){
                    throw new \Exception('ID especialidade: ' . $id . " não encontrado", 404);
                }
                return true;
            }
        }

    }

    public function findEspecialidadeAndCreateObject($ids)
    {
        if(!empty($ids)){
            $obj = array();
            foreach($ids as $id){
                $find = Especialidade::where('id', $id)->first();
                $arr = array(
                    'id' => $id,
                    'nome' => $find->nome,

                );

                array_push($obj, $arr);
            }

            return $obj;
        }

        if(empty($ids)){
            return null;
        }

    }

}
