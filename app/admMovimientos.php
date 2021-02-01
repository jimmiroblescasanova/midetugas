<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admMovimientos extends Model
{
    protected $connection ="mssql";
    protected $table = "admMovimientos";
    protected $primaryKey = 'CIDMOVIMIENTO';
    public $timestamps = false;

    protected $guarded = [];
}
