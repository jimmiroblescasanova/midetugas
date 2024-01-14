<?php

namespace App;

use App\Client;
use App\Factor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Measurer extends Model
{
    use HasFactory;

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

    public function factor()
    {
        return $this->belongsTo(Factor::class);
    }

    public function scopeSearch($query, $search)
    {
        $search = "%$search%";

        return $query->where('brand', 'LIKE', $search)
            ->orWhere('model', 'LIKE', $search)
            ->orWhere('serial_number', 'LIKE', $search);
    }
}
