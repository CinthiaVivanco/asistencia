<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistenciadiaria extends Model
{
    protected $table = 'asistenciadiarias';
    public $timestamps=false;

    public $incrementing = false;
    public $keyType = 'string';


}
