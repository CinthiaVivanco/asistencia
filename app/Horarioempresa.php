<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horarioempresa extends Model
{
    protected $table = 'horarioempresas';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

    public function horario()
    {
        return $this->belongsTo('App\Horario');
    }


}
