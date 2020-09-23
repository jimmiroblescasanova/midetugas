<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurer extends Model
{
    protected $guarded = [];

    public function setCodeAttribute($val)
    {
        $this->attributes['code'] = strtoupper($val);
    }

    public function setSerialNumberAttribute($val)
    {
        $this->attributes['serial_number'] = strtoupper($val);
    }

}
