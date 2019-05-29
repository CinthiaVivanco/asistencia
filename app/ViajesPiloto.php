<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViajesPiloto extends Model
{
    protected $table = 'viajespiloto';
    public $timestamps=false;


    protected $primaryKey = 'idpiloto';
	public $incrementing = false;
	public $keyType = 'string';
}
