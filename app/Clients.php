<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $guarded = [];

    public function measurer()
    {
        return $this->hasOne('App\Measurer');
    }
}
