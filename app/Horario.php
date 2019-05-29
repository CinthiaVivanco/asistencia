<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function trabajador()
    {
        return $this->hasMany('App\Trabajador');
    }

    public function horarioempresa()
    {
        return $this->hasMany('App\Horarioempresa');
    }

}
