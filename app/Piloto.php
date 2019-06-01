<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piloto extends Model
{
    protected $table = 'pilotos';
    public $timestamps=false;


    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';
}
