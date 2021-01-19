<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admConceptos extends Model
{
    protected $connection ="mssql";
    protected $table = "admConceptos";
    protected $primaryKey = 'CIDCONCEPTODOCUMENTO';
    public $timestamps = false;

    protected $guarded = [];
}
