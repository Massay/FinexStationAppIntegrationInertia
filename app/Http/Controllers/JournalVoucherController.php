<?php

namespace App\Http\Controllers;

use App\Actions\FuelPump\FuelPumpApiConnector;
use App\Actions\FuelPump\ProcessAnalysisSale;
use App\Models\Account;
use App\Models\Project;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JournalVoucherController extends Controller
{

    public function __construct(private FuelPumpApiConnector $fuelPumpApiConnector){

    }
    public function create(Request $request)
    {
       

        $data = [];
        $formData = [];
        $date = null;

        $selectedStation = null;
        
        if($request->filled('station_id') && $request->filled('date')){

            $id = trim($request->station_id);
            $date = Carbon::parse($request->date);
            $data = $this->fuelPumpApiConnector->getDataByStation($id, $date);

            // $priceStructure = ['agoPrice' => $fuelPrice['ago'],'pmsPrice' => $fuelPrice['pms']];
            $formData =   ProcessAnalysisSale::process($data,"JV",[],$data['price']);

            $selectedStation = Station::where('station_id', $request->station_id)->first();

        }

    

        $accounts = Account::select('Id','Name')->get();

        $projects = Project::select('Id',"Name")->get();

        $stations = Station::select('station_id','name')->get();
      
        return Inertia::render('JV/Create',[
            'stations' => fn () =>  $stations,
            'project_id' => $selectedStation['project_id'],
            'data' => fn () => $data,
            'year' => fn () => Carbon::parse($request->date)->format('Y'),
            'formData' => fn () => $formData,
            'projects' => fn () => $projects,
            'filters' => fn () => $request->only(['station_id','date']),
            'accounts' => fn () => $accounts
        ]);
    }
}
