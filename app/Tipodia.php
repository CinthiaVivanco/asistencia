<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodia extends Model
{
    protected $table = 'tipodias';
    public $timestamps=false;

    
    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function dia()
    {
        return $this->hasMany('App\Dia');
    }


}


