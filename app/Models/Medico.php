<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Medico extends Model
{
    protected $table = 'medico';

    public function getEspecialidadesAttribute($value)
    {
        return json_decode($value);
    }

    public function setEspecialidadesAttribute($value)
    {
        $this->attributes['especialidades'] = json_encode($value);
    }
}
