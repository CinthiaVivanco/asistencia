<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargoempresa extends Model
{
    protected $table = 'cargoempresas';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

    public function cargo()
    {
        return $this->belongsTo('App\Cargo');
    }


}
