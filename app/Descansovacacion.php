<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descansovacacion extends Model
{
    protected $table = 'descansovacaciones';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function Local()
    {
        return $this->belongsTo('App\Local');
    }
    public function trabajador()
    {
        return $this->belongsTo('App\Trabajador');
    }

    public function semana()
    {
        return $this->belongsTo('App\Semana');
    }

    public function horariotrabajador()
    {
        return $this->belongsTo('App\Horariotrabajador');
    }

}