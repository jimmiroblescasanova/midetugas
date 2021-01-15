<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admClientes extends Model
{
    protected $connection ="mssql";
    protected $table = "admClientes";
    protected $primaryKey = 'CIDCLIENTEPROVEEDOR';

    public $timestamps = false;

    protected $guarded = [];

}
