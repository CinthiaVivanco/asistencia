<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rols';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    
    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function rolopcion()
    {
        return $this->hasMany('App\RolOpcion');
    }

}
