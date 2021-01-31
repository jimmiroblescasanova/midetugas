<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    protected $guarded = [];


    public function getFullAddressAttribute()
    {
        return "{$this->line_1}  Ext. {$this->line_2} Int. {$this->line_3}, {$this->locality}, {$this->city}, {$this->state_province}, {$this->country}, CP {$this->zipcode}";
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
