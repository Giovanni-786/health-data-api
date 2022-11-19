<?php

namespace App\Services;


use App\Models\Medicamentos;

class MedicamentoService
{

    public function checkExistsMedicamentoId($ids)
    {
        if(!empty($ids)){
            foreach($ids as $medicamentoId){
                $findMedicamentosById = Medicamentos::where('id', $medicamentoId)->first();
                if(!$findMedicamentosById){
                    throw new \Exception('ID medicamento: ' . $medicamentoId . " não encontrado", 404);
                }
                return true;
            }
        }

    }

    public function findMedicamentosAndCreateObject($ids)
    {
        if(!empty($ids)){
            $alergiaObj = array();
            foreach($ids as $medicamentoId){
                $findMedicamento = Medicamentos::where('id', $medicamentoId)->first();
                $arr = array(
                    'id' => $medicamentoId,
                    'nome' => $findMedicamento->nome,
                    'dosagem' => $findMedicamento->dosagem,
                    'unidade_medida' => $findMedicamento->unidade_medida
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
