<?php

namespace App\Services;


use App\Models\Medicamentos;
use App\Models\Patologias;

class PatologiaService
{

    public function checkExistsPatologiaId($ids)
    {
        if(!empty($ids)){
            foreach($ids as $patologiaId){
                $findMedicamentosById = Patologias::where('id', $patologiaId)->first();
                if(!$findMedicamentosById){
                    throw new \Exception('ID patologia: ' . $patologiaId . " não encontrado", 404);
                }
                return true;
            }
        }

    }

    public function findPatologiasAndCreateObject($ids)
    {
        if(!empty($ids)){
            $patologiaObj = array();
            foreach($ids as $patologiaId){
                $findPatologia = Patologias::where('id', $patologiaId)->first();
                $arr = array(
                    'id' => $patologiaId,
                    'nome' => $findPatologia->nome,
                    'tipo' => $findPatologia->tipo
                );

                array_push($patologiaObj, $arr);
            }
            return $patologiaObj;
        }

        if(empty($ids)){
            return null;
        }

    }

}
