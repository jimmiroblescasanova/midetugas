<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admDocumentos extends Model
{
    protected $connection ="mssql";
    protected $table = "admDocumentos";
    protected $primaryKey = 'CIDDOCUMENTO';
    public $timestamps = false;

    protected $guarded = [];
}
