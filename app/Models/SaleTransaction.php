<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleTransaction extends Model
{

     protected $casts = [
          'date' => 'datetime:Y-m-d',
          'created_at' => 'datetime:Y-m-d'
     ];
    protected $fillable = ['type','sale_id','source_station_id','reference','user_id','date'];

    public function user(){
         return $this->belongsTo(User::class);
    }


    public function station(){
        return $this->belongsTo(Station::class,'source_station_id','station_id');
   }
}
