<?php

namespace App\Http\Controllers;

use App\Actions\FuelPump\FuelPumpApiConnector;
use App\Actions\FuelPump\ProcessAnalysisSale;
use App\Models\Account;
use App\Models\Project;
use App\Models\Station;
use App\Models\UnitPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SivController extends Controller
{


    public function __construct(private FuelPumpApiConnector $fuelPumpApiConnector) {}
    public function create(Request $request)
    {



        $data = [];
        $formData = [];
        $date = null;

        $fuelPrice = null;



        if ($request->filled('station_id') && $request->filled('date')) {

            $id = trim($request->station_id);
            $date = Carbon::parse($request->date);
            $data = $this->fuelPumpApiConnector->getDataByStation($id, $date);

            $year = $date->year;
            $month = $date->month;
            $fuelPrice = UnitPrice::where('month',$month)->where('year', $year)->first();
            $priceStructure = ['agoPrice' => $fuelPrice['ago'],'pmsPrice' => $fuelPrice['pms']];
            $formData =   ProcessAnalysisSale::process($data, "SIV",$priceStructure);


            

            
        }

       // dd($fuelPrice);
        $accounts = Account::select('Id', 'Name')->get();
        $projects = Project::select('Id', "Name")->get();
        $stations = Station::select('station_id', 'name')->get();

        return Inertia::render('SIV/Create', [
            'stations' => $stations,
            'data' => $data,
            'year' => Carbon::parse($request->date)->format('Y'),
            'formData' => $formData,
            'projects' => $projects,
            'filters' => $request->only(['station_id', 'date']),
            'accounts' => $accounts,
            'fuelPrice' => $fuelPrice
        ]);
    }
}
