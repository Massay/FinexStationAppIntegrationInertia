<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleTransaction extends Model
{
    protected $fillable = ['type','sale_id','source_station_id','reference','user_id'];
}
