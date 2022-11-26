<?php

namespace App\Services;

use App\Models\Alergias;

class ConsultaService
{

    // public function __construct(CompanyRepository $companyRepository, DigisacFun $digisacFun)
    // {
    //     $this->companyRepository = $companyRepository;
    //     $this->digisac = $digisacFun;
    // }

    public function checkStoreForIdMedico($id)
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

}
