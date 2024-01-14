<?php

namespace App;

use App\Measurer;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $guarded = [];

    public function measurer()
    {
        return $this->hasMany(Measurer::class);
    }
}
