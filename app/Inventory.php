<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    protected $guarded = [];
    protected $dates = ['date'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function tank()
    {
        return $this->belongsTo('App\Tank');
    }

    public function setQuantityAttribute($val)
    {
        $this->attributes['quantity'] = $val * 100;
    }

    public function getQuantityAttribute()
    {
        return $this->attributes['quantity'] / 100;
    }
}
