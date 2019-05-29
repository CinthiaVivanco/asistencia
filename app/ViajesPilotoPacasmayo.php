<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViajesPilotoPacasmayo extends Model
{
    protected $table = 'viajespilotopacasmayo';
    public $timestamps=false;

    protected $primaryKey = 'idpiloto';
	public $incrementing = false;
	public $keyType = 'string';
}


