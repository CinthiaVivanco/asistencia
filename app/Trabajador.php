<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;



    public function descansovacacion()
    {
        return $this->hasMany('App\Descansovacacion');
    }


    public function cargo()
    {
        return $this->belongsTo('App\Cargo');
    }

    public function tipodocumento()
    {
        return $this->belongsTo('App\Tipodocumento');
    }


    public function horario()
    {
        return $this->belongsTo('App\Horario');
    }

    public function local()
    {
        return $this->belongsTo('App\Local');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

}
