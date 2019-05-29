<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistenciatrabajador extends Model
{
    protected $table = 'asistenciatrabajadores';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';



    public function semana()
    {
        return $this->belongsTo('App\Semana');
    }

    public function trabajador()
    {
        return $this->belongsTo('App\Trabajador');
    }

    public function horariotrabajador()
    {
        return $this->belongsTo('App\Horariotrabajador');
    }


}
