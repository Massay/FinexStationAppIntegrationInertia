<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Casts\Json;

interface FuelPumpApiInterface{

    public function setCredentials($username, $password);

    public function connect();

    
    public function  getStations():Array;

    public function getDataByStation($stationId, $date);

    
    public function getCurrentToken();

}