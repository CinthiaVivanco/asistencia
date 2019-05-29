<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoPiloto extends Model
{
    protected $table = 'periodopiloto';
    public $timestamps=false;


    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';
}
