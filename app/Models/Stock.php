<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $connection = 'sqlsrv_db';

    protected $table = 'Stock';
    public $timestamps = false;
}
