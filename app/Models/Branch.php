<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $connection = 'sqlsrv_db';

    protected $table = 'Branch';
    public $timestamps = false;
}
