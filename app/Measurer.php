<?php

namespace App;

use App\Client;
use Illuminate\Database\Eloquent\Model;

class Measurer extends Model
{
    protected $guarded = [];

    public function setModelAttribute($val)
    {
        $this->attributes['model'] = strtoupper($val);
    }

    public function setSerialNumberAttribute($val)
    {
        $this->attributes['serial_number'] = strtoupper($val);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeSearchMeasurer($query, $search)
    {
        $search = "%$search%";

        return $query->where('brand', 'LIKE', $search)
            ->orWhere('model', 'LIKE', $search)
            ->orWhere('serial_number', 'LIKE', $search);
    }
}
