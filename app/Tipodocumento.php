<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodocumento extends Model
{
    protected $table = 'tipodocumentos';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';



    public function trabajador()
    {
        return $this->hasMany('App\Trabajador');
    }


}