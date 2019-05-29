<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargos';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    public function trabajador()
    {
        return $this->hasMany('App\Trabajador');
    }
    
    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function cargoempresa()
    {
        return $this->hasMany('App\Cargoempresa');
    }

}