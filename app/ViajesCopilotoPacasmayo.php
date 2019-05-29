<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViajesCopilotoPacasmayo extends Model
{
    protected $table = 'viajescopilotopacasmayo';
    public $timestamps=false;

    protected $primaryKey = 'idpiloto';
	public $incrementing = false;
	public $keyType = 'string';
}


