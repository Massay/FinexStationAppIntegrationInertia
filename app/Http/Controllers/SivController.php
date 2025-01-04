<?php

namespace App\Http\Controllers;

use App\Actions\FuelPump\FuelPumpApiConnector;
use App\Actions\FuelPump\ProcessAnalysisSale;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Project;
use App\Models\SaleTransaction;
use App\Models\Station;
use App\Models\UnitPrice;
use App\Services\FuelPumpDataTypes\SivFuelPumpData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SivController extends Controller
{


    public function __construct(private SivFuelPumpData $sivFuelPumpData) {}
    public function create(Request $request)
    {



        $data = [];
        $formData = [];
        $date = null;

        $fuelPrice = null;
        $selectedStation = null;

        $date = Carbon::parse($request->date);
        $year = $date->year;
        //Carbon::parse($request->date)->year

        if ($request->filled('station_id') && $request->filled('date')) {

            $id = trim($request->station_id);

            // $data = $this->fuelPumpApiConnector->getDataByStation($id, $date);

            $data = $this->sivFuelPumpData->getData($date,$id);

            if($request->filled('initReq')){
                $currentSaleId = $data['sale_info']['id'];

                $exists = SaleTransaction::where('type','SIV')->where('sale_id', $currentSaleId)->exists();

                if($exists){
                    abort(403,"This Sale Transaction has already being entered");
                }
            }



            $month = $date->month;
            $fuelPrice = UnitPrice::where('month',$month)->where('year', $year)->first();
            $priceStructure = ['agoPrice' => $fuelPrice['ago'],'pmsPrice' => $fuelPrice['pms']];
            $formData = $this->sivFuelPumpData->getFields($data, $priceStructure, $data['price']);
            $selectedStation = Station::where('station_id', $request->station_id)->first();


        }

        $accounts = Account::select('Id', 'Name')->get();
        $projects = Project::select('Id', "Name")->get();
        $stations = Station::select('station_id', 'name')->get();
        $branches = Branch::select('Id','Name')->get();

        return Inertia::render('SIV/Create', [
            'stations' =>fn () =>  $stations,
            'selectedStation' => $selectedStation,
            'data' => fn () => $data,
            'year' => $year,
            'formData' => fn () => $formData,
            'projects' => fn () => $projects,
            'filters' => fn () => $request->only(['station_id', 'date']),
            'accounts' =>fn () =>  $accounts,
            'fuelPrice' => fn () => $fuelPrice,
            'branches' =>  fn () => $branches,
        ]);
    }
}
