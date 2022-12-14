<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setNameAttribute($val): string
    {
        return $this->attributes['name'] = strtoupper($val);
    }

    public function setRfcAttribute($val): string
    {
        return $this->attributes['rfc'] = strtoupper($val);
    }

    public function setReferenceAttribute($val): string
    {
        return $this->attributes['reference'] = strtoupper($val);
    }

    public function measurer()
    {
        return $this->hasOne('App\Measurer');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function setBalanceAttribute($val)
    {
        return $this->attributes['balance'] = $val * 100;
    }

    public function getBalanceAttribute()
    {
        return $this->attributes['balance'] / 100;
    }

    public function setDepositAttribute($val)
    {
        return $this->attributes['deposit'] = $val * 100;
    }

    public function getDepositAttribute()
    {
        return $this->attributes['deposit'] / 100;
    }

    public function getFullAddressAttribute()
    {
        return "{$this->line_1}  Ext. {$this->line_2} Int. {$this->line_3}, {$this->locality}, {$this->city}, {$this->state_province}, {$this->country}, CP {$this->zipcode}";
    }

    public function getPhoneNumberAttribute()
    {
        return $this->country_code . $this->phone;
    }

    public function getAccountNumberAttribute()
    {
        return str_pad($this->attributes['id'], 4, '0', STR_PAD_LEFT);
    }

    public function getSearchableNameAttribute()
    {
        return $this->attributes['name'] . ' - ' . $this->attributes['shortName'];
    }

    public function scopeSearch($query, $search)
    {
        $search = "%$search%";

        return $query->where('name', 'LIKE', $search)
            ->orWhere('shortName', 'LIKE', $search)
            ->orWhere('reference', 'LIKE', $search);
    }
}
