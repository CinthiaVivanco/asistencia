<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';
    public $timestamps=false;

    
    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';


    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

    public function ciudad()
    {
        return $this->belongsTo('App\Ciudad');
    }

    public function trabajador()
    {
        return $this->hasMany('App\Trabajador');
    }
   
}



