<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $dates = [
        'date',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function documents()
    {
        return $this->belongsToMany('App\Document')
            ->using(DocumentPayment::class)
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function setAmountAttribute($val) {
        return $this->attributes['amount'] = $val * 100;
    }

    public function getAmountAttribute() {
        return $this->attributes['amount'] / 100;
    }

    public function setBalanceAttribute($val) {
        return $this->attributes['balance'] = $val * 100;
    }

    public function getBalanceAttribute() {
        return $this->attributes['balance'] / 100;
    }

    public function scopeSearch($query, $search)
    {
        $search = "%$search%";

        return $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'LIKE', $search);
            })
            ->orWhere('payments.id', 'LIKE', $search)
            ->orWhere('amount', 'LIKE', $search);
    }

    public function scopeWithClientName($query)
    {
        return $query->join('clients', 'payments.client_id', '=', 'clients.id')
            ->select('payments.*', 'clients.id as idClient', 'clients.name as name');
    }
}
