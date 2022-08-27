<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $dates = [
        'date',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function documents()
    {
        return $this->belongsToMany('App\Document')
            ->using(DocumentPayment::class)
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function setAmountAttribute($val) {
        return $this->attributes['amount'] = $val * 100;
    }

    public function getAmountAttribute() {
        return $this->attributes['amount'] / 100;
    }
}
