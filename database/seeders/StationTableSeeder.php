<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $st = new Station();
        $st->station_id = 32;
        $st->name = "(Fajara) Kanifing Station";
        $st->save();

        $st = new Station();
        $st->station_id = 33;
        $st->name = "Banjul Station";
        $st->save();


        $st = new Station();
        $st->station_id = 34;
        $st->name = "Brikama Station";
        $st->save();



        $st = new Station();
        $st->station_id = 35;
        $st->name = "Basse Station";
        $st->save();


        $st = new Station();
        $st->station_id = 36;
        $st->name = "Farafenni Station";
        $st->save();



        $st = new Station();
        $st->station_id = 37;
        $st->name = "Soma Station";
        $st->save();


        $st = new Station();
        $st->station_id = 38;
        $st->name = "Abuko  Station";
        $st->save();


        $st = new Station();
        $st->station_id = 39;
        $st->name = "Bansang Station";
        $st->save();


        $st = new Station();
        $st->station_id = 40;
        $st->name = "Bundung Station";
        $st->save();

        $st = new Station();
        $st->station_id = 42;
        $st->name = "Brusubi Station";
        $st->save();


        $st = new Station();
        $st->station_id = 43;
        $st->name = "Yundum Station";
        $st->save();
    }
}
