<?php

namespace App;

use App\Project;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $guarded = [];

    protected $dates = ['manufacturing_date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function setSerialNumberAttribute($sn)
    {
        return $this->attributes['serial_number'] = Str::upper($sn);
    }

}
