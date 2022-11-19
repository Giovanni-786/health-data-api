<?php

namespace App\Services;

use App\Models\Alergias;

class AlergiaService
{

    // public function __construct(CompanyRepository $companyRepository, DigisacFun $digisacFun)
    // {
    //     $this->companyRepository = $companyRepository;
    //     $this->digisac = $digisacFun;
    // }

    public function checkExistsAlergiasId($ids)
    {

        if(!empty($ids)){
            foreach($ids as $alergiaId){
                $findAlergiasById = Alergias::where('id', $alergiaId)->first();
                if(!$findAlergiasById){
                    throw new \Exception('ID alergia: ' . $alergiaId . ' não encontrado', 404);
                }
                return true;
            }
        }

        return null;
    }

    public function findAlergiasAndCreateObject($ids)
    {

        if(!empty($ids)){

            $alergiaObj = array();
            foreach($ids as $alergiaId){

                $findAlergia = Alergias::where('id', $alergiaId)->first();
                $arr = array(
                    'id' => $alergiaId,
                    'nome' => $findAlergia->nome,
                    'tipo_alergia' => $findAlergia->tipo
                );

                array_push($alergiaObj, $arr);
            }

            return $alergiaObj;
        }

        if(empty($ids)){
            return null;

        }


    }

}
