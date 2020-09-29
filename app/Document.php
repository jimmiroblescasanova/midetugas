<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    protected $dates = [
        'date',
        'payment_date'
    ];

    public function client()
    {
        return $this->belongsTo('App\Clients');
    }
}