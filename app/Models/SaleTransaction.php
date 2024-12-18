<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleTransaction extends Model
{
    protected $fillable = ['type','sale_id','source_station_id','reference','user_id','date'];

    public function user(){
         return $this->belongsTo(User::class);
    }


    public function station(){
        return $this->belongsTo(Station::class,'source_station_id','station_id');
   }
}
