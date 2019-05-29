<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PilotosAsistencia extends Model
{
    protected $table = 'pilotosasistencia';
    public $timestamps=false;

    protected $primaryKey = 'Id';
	public $incrementing = false;
	public $keyType = 'string';
}
