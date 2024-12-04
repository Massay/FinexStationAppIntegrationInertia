<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitPrice extends Model
{
    protected $fillable = ['ago','pms','year','month'];


    protected $casts = [
        'ago'  => 'double',
        'pms' => 'double',
        'year' => 'integer',
        'month' => 'integer',
        // 'date' => 'date'
    ];
}
