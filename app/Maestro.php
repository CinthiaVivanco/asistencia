<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maestro extends Model
{
    protected $table = 'maestros';
    public $timestamps=false;

    protected $primaryKey = 'codigoatributo';
    public $incrementing = false;
    public $keyType = 'string';

}