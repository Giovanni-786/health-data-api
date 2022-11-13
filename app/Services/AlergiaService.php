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

}
