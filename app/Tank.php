<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $guarded = [];

    protected $dates = ['manufacturing_date'];

    public function setSerialNumberAttribute($sn)
    {
        $this->attributes['serial_number'] = Str::upper($sn);
    }
}
