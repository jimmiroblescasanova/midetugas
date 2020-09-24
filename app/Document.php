<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Clients');
    }
}
