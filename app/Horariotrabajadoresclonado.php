<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horariotrabajadoresclonado extends Model
{
    protected $table = 'horariotrabajadoresclonados';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


}
