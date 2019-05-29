<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisouserempresa extends Model
{
    protected $table = 'permisouserempresas';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
