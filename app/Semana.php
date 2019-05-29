<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semana extends Model
{
    protected $table = 'semanas';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function descansovacacion()
    {
        return $this->hasMany('App\Descansovacacion');
    }

    public function horariotrabajador()
    {
        return $this->hasMany('App\Horariotrabajador');
    }

    public function asistenciatrabajador()
    {
        return $this->hasMany('App\Asistenciatrabajador');
    }


}
