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

    public function checkExistsAlergiasId($alergiaIds)
    {
        foreach($alergiaIds as $alergiaId){
            $findAlergiasById = Alergias::where('id', $alergiaId)->first();
            if(!$findAlergiasById){
                return ('ID ' . $alergiaId . " não encontrado");
            }
        }

    }

    public function findAlergiasAndCreateObject($alergiaIds)
    {
        $alergiaObj = array();
        foreach($alergiaIds as $alergiaId){
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

}
