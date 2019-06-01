<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    protected $table = 'dias';
    public $timestamps=false;

    
    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';


     public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }

     public function tipodia()
    {
        return $this->belongsTo('App\Tipodia');
    }

     public function semana()
    {
        return $this->belongsTo('App\Semana');
    }

    public function dia()
    {
        return $this->hasMany('App\Dia');
    }
   
}



