<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoNum extends Model
{
    protected $primaryKey = "Id";

    public $timestamps = false;

    protected $fillable = [
        'EditedBy',
        'NextNum',
        'Name'
    ];

    protected $connection = 'sqlsrv_db';

    protected $table = 'AutoNum';
}
