<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ilog extends Model
{
    protected $table = 'ilogs';
    public $timestamps=false;

    protected $primaryKey = 'fechatime';
    public $incrementing = false;
    public $keyType = 'string';

}