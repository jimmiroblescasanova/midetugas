<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $guarded = [];

    protected $dates = ['manufacturing_date'];
}
