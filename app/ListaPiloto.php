<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaPiloto extends Model
{
    protected $table = 'listapiloto';
    public $timestamps=false;


    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';
}
