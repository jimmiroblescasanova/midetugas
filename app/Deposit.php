<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $guarded = [];

    protected $dates = ['date'];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function measurer()
    {
        return $this->belongsTo('App\Measurer');
    }

    public function setTotalAttribute($val)
    {
        return $this->attributes['total'] = $val * 100;
    }

    public function getTotalAttribute()
    {
        return $this->attributes['total'] / 100;
    }
}
