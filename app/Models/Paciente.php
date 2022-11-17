<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;


class Paciente extends Model
{

    public $table = 'paciente';

    protected $casts = [
        'alergias' => 'array'
    ];


}
