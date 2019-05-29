<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contratos';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;

    public function detallejornadalaboral()
    {
        return $this->hasMany('App\Detallejornadalaboral');
    }

    public function tipocontratotrabajador()
    {
        return $this->belongsTo('App\Tipocontratotrabajador');
    }

    public function trabajador()
    {
        return $this->belongsTo('App\Trabajador');
    }

    public function formato()
    {
        return $this->belongsTo('App\Formato');
    }

    public function local()
    {
        return $this->belongsTo('App\Local');
    }

     public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function gerencia()
    {
        return $this->belongsTo('App\Gerencia');
    }

    public function cargo()
    {
        return $this->belongsTo('App\Cargo');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

     public function tipocontrato()
    {
        return $this->belongsTo('App\Tipocontrato');
    }

    public function tipopago()
    {
        return $this->belongsTo('App\Tipopago');
    }

    public function periodicidad()
    {
        return $this->belongsTo('App\periodicidad');
    }




    
}
