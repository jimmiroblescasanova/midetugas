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
        return $this->belongsToMany('App\Document');
    }
}
