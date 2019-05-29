<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidades';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    
    public function contrato()
    {
        return $this->hasMany('App\Contrato');
    }

    public function cargo()
    {
        return $this->hasMany('App\Cargo');
    }   


    public function area()
    {
        return $this->belongsTo('App\Area');
    }

}
