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
        $price->ago = 51.55;
        $price->pms = 44.48;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 2;
        $price->ago = 51.10;
        $price->pms = 43.44;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 3;
        $price->ago = 51.0;
        $price->pms = 43.11;
        $price->save();


        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 4;
        $price->ago = 52.56;
        $price->pms = 46.74;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 5;
        $price->ago = 51.25;
        $price->pms = 51.27;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 6;
        $price->ago = 53.03;
        $price->pms = 52.29;
        $price->save();


        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 7;//july
        $price->ago = 52.06;
        $price->pms = 51.29;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 8;
        $price->ago = 53.26;
        $price->pms = 51.29;
        $price->save();


        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 9;
        $price->ago = 51.36;
        $price->pms = 51.29;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 10;
        $price->ago = 49.33;
        $price->pms = 51.29;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 11;
        $price->ago = 49.34;
        $price->pms = 51.29;
        $price->save();



        $price = new UnitPrice();
        $price->year = 2024;
        $price->month = 12;
        $price->ago = 49.34;
        $price->pms = 51.29;
        $price->save();


    }
}
