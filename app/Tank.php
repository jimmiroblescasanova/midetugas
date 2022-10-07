<?php

namespace App;

use App\Project;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tank extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['manufacturing_date'];

    protected $casts = [
        'manufacturing_date' => 'date:Y-m-d',
    ];

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

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('brand', 'LIKE', '%' . $search . '%')
            ->orWhere('model', 'LIKE', '%' . $search . '%')
            ->orWhere('serial_number', 'LIKE', '%' . $search . '%')
            ->orWhere('capacity', 'LIKE', '%' . $search . '%');
    }

}
