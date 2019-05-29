<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';
    public $timestamps=false;

    
    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

    public function local()
    {
        return $this->hasMany('App\Local');
    }

}


