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
}
