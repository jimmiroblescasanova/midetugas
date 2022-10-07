<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'reference'
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('total_capacity', 'LIKE', '%' . $search . '%')
            ->orWhere('reference', 'LIKE', '%' . $search . '%');
    }

    public function tanks()
    {
        return $this->hasMany('App\Tank');
    }

    public function inventories()
    {
        return $this->hasMany('App\Inventory');
    }

    public function clients()
    {
        return $this->hasMany('App\Client');
    }
}
