<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $guarded = [];
//    protected $with = ['measurer'];

    public function setNameAttribute($val)
    {
        $this->attributes['name'] = strtoupper($val);
    }

    public function setRfcAttribute($val)
    {
        $this->attributes['rfc'] = strtoupper($val);
    }

    public function measurer()
    {
        return $this->belongsTo('App\Measurer');
    }

}
