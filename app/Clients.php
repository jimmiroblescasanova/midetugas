<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $guarded = [];

    public function setNameAttribute($val): string
    {
        return $this->attributes['name'] = strtoupper($val);
    }

    public function setRfcAttribute($val): string
    {
        return $this->attributes['rfc'] = strtoupper($val);
    }

    public function measurer()
    {
        return $this->belongsTo('App\Measurer');
    }

    public function address()
    {
        return $this->belongsTo('App\Addresses');
    }

    public function setBalanceAttribute($val)
    {
        return $this->attributes['balance'] = $val * 100;
    }

    public function getBalanceAttribute()
    {
        return $this->attributes['balance'] / 100;
    }

    public function setAdvancePaymentAttribute($val)
    {
        return $this->attributes['advance_payment'] = $val * 100;
    }

    public function getAdvancePaymentAttribute()
    {
        return $this->attributes['advance_payment'] / 100;
    }

}
