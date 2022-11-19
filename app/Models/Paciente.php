<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;


class Paciente extends Model
{

    public $table = 'paciente';

    public function getAlergiasAttribute($value)
    {
        return json_decode($value);
    }

    public function setAlergiasAttribute($value)
    {
        $this->attributes['alergias'] = json_encode($value);
    }

    public function getMedicamentosAttribute($value)
    {
        return json_decode($value);
    }

    public function setMedicamentosAttribute($value)
    {
        $this->attributes['medicamentos'] = json_encode($value);
    }

    public function getPatologiasAttribute($value)
    {
        return json_decode($value);
    }

    public function setPatologiasAttribute($value)
    {
        $this->attributes['patologias'] = json_encode($value);
    }

}
