<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horariotrabajador extends Model
{
    protected $table = 'horariotrabajadores';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function descansovacacion()
    {
        return $this->hasMany('App\Descansovacacion');
    }
    public function semana()
    {
        return $this->belongsTo('App\Semana');
    }

    public function trabajador()
    {
        return $this->belongsTo('App\Trabajador');
    }

    public function asistenciatrabajador()
    {
        return $this->hasOne('App\Asistenciatrabajador');
    }


}
