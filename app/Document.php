<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    protected $dates = [
        'date',
        'payment_date'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function payments()
    {
        return $this->belongsToMany('App\Payment')
            ->using(RoleUser::class)
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function setPreviousBalanceAttribute($val)
    {
        return $this->attributes['previous_balance'] = $val * 100;
    }

    public function getPreviousBalanceAttribute()
    {
        return $this->attributes['previous_balance'] / 100;
    }

    public function setSubtotalAttribute($val)
    {
        return $this->attributes['subtotal'] = $val * 100;
    }

    public function getSubtotalAttribute()
    {
        return $this->attributes['subtotal'] / 100;
    }

    public function setIvaAttribute($val)
    {
        return $this->attributes['iva'] = $val * 100;
    }

    public function getIvaAttribute()
    {
        return $this->attributes['iva'] / 100;
    }

    public function setTotalAttribute($val)
    {
        return $this->attributes['total'] = $val * 100;
    }

    public function getTotalAttribute()
    {
        return $this->attributes['total'] / 100;
    }

    public function setPendingAttribute($val)
    {
        return $this->attributes['pending'] = $val * 100;
    }

    public function getPendingAttribute()
    {
        return $this->attributes['pending'] / 100;
    }

    public function setDiscountAttribute($val)
    {
        return $this->attributes['discount'] = $val * 100;
    }

    public function getDiscountAttribute()
    {
        return $this->attributes['discount'] / 100;
    }

    public function setAdmChargeAttribute($val)
    {
        return $this->attributes['adm_charge'] = $val * 100;
    }

    public function getAdmChargeAttribute()
    {
        return $this->attributes['adm_charge'] / 100;
    }

    public function scopePending($query)
    {
        $query->where('status', 1);
    }

    public function scopeSearch($query, $search)
    {
        $search = "%$search%";

        return $query->whereHas('client', function($q) use ($search){
                $q->where('name', 'LIKE', $search);
            })
            ->orWhere('documents.id', 'LIKE', $search)
            ->orWhere('period', 'LIKE', $search)
            ->orWhere('total', 'LIKE', $search);
    }

    public function scopeWithClientName($query)
    {
        return $query->join('clients', 'documents.client_id', '=', 'clients.id')
            ->select('documents.*', 'clients.id as idClient', 'clients.name as name');
    }
}
