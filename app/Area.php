<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    public function trabajador()
    {
        return $this->hasMany('App\Trabajador');
    }

    public function gerencia()
    {
        return $this->belongsTo('App\Gerencia');
    }



}