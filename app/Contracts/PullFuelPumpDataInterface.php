<?php

namespace App\Contracts;


interface   PullFuelPumpDataInterface{


    public function getData($date, $stationId);


    public function getFields(array $data, $priceStructure, $actualPrice);

}