<?php

namespace App\Actions\FuelPump;

use App\Contracts\FuelPumpApiInterface;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Http;

class FuelPumpApiConnector implements FuelPumpApiInterface
{

    // private static $instance;
    private $username;
    private $password;
    private $token;
    private $token_type;

    public function __construct($username, $password)
    {
        $this->username = trim($username);
        $this->password = trim($password);
    }


    public function setCredentials($username, $password)
    {
        $this->username = trim($username);
        $this->password = trim($password);
    }

    public function getStations(): array
    {
        $response = Http::fuelPumpApp()->withToken($this->token)
            ->get("/api/get/stations");

        if ($response->successful()) {
            //dd($response->json());
            return $response->json();
        } else {
            return [];
        }
    }

    public function getDataByStation($stationId, $date)
    {
        $response = Http::fuelPumpApp()->withToken($this->token)
            ->get("/api/get/sales-by-stations/?department_id=$stationId&date=$date");

        if ($response->successful()) {
            return $response->json();
        } else {
            return [];
        }
    }


    public function getCurrentToken()
    {
        return $this->token;
    }
    public  function connect(): array
    {
        $response = Http::fuelPumpApp()->asForm()
            ->post("/api/login", [
                'email' => $this->username,
                'password' =>  $this->password
            ]);

        if ($response->successful()) {
            $this->token = $response['token'];
            $this->token_type = $response['token_type'];
            return  $response->json();
        }

        return $response->json();
    }
}
