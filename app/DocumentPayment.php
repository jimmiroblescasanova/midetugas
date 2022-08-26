<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DocumentPayment extends Pivot
{
    public function setAmountAtribute($val)
    {
        return $this->attributes['amount'] = $val * 100;
    }

    public function getAmountAttribute()
    {
        return $this->attributes['amount'] / 100;
    }

}
