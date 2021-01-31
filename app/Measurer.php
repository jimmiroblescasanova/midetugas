<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurer extends Model
{
    protected $guarded = [];

    public function setModelAttribute($val)
    {
        $this->attributes['model'] = strtoupper($val);
    }

    public function setSerialNumberAttribute($val)
    {
        $this->attributes['serial_number'] = strtoupper($val);
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

}
