<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    public $timestamps=false;

    
    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	 public function local()
    {
        return $this->hasMany('App\Local');
    }

    public function horarioempresa()
    {
        return $this->hasMany('App\Horarioempresa');
    }

    public function cargoempresa()
    {
        return $this->hasMany('App\Cargoempresa');
    }

    public function permisouserempresa()
    {
        return $this->hasMany('App\Permisouserempresa');
    }
    
}
