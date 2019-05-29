<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisousersede extends Model
{
    protected $table = 'permisousersedes';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
