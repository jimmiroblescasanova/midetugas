<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'reference'
    ];

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
