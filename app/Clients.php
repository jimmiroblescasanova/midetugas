<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $guarded = [];

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

    public function setBalanceAttribute($val)
    {
        $this->attributes['balance'] = $val * 100;
    }

    public function getBalanceAttribute()
    {
        return $this->attributes['balance'] / 100;
    }

    public function setAdvancePaymentAttribute($val)
    {
        $this->attributes['advance_payment'] = $val * 100;
    }

    public function getAdvancePaymentAttribute()
    {
        return $this->attributes['advance_payment'] / 100;
    }

}
