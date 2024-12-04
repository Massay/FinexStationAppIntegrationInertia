<?php

namespace Database\Seeders;

use App\Models\UnitPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        
        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 1;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 2;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 3;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();


        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 4;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 5;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 6;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();


        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 7;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 8;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();


        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 9;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 10;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 11;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 12;
        $price->ago = 41.0;
        $price->pms = 51.0;
        $price->save();


    }
}
