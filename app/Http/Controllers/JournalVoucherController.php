<?php

namespace App\Http\Controllers;

use App\Actions\FuelPump\FuelPumpApiConnector;
use App\Actions\FuelPump\ProcessAnalysisSale;
use App\Models\Account;
use App\Models\Project;
use App\Models\SaleTransaction;
use App\Models\Station;
use App\Services\FuelPumpDataTypes\JvFuelPumpData;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JournalVoucherController extends Controller
{

    public function __construct(private JvFuelPumpData $jvFuelPumpData)
    {
    }

    public function index()
    {

        return Inertia::render('JV/Create');
    }
    public function create(Request $request)
    {


        $data = [];
        $formData = [];
        $date = null;

        $selectedStation = null;

        $projectId = null;

        $accounts = [];
        $projects = [];
        $stations = Station::select('station_id', 'name')->get();

        $year = null;

        try {

            if ($request->has('station_id') && $request->has('date')) {

                $id = trim($request->station_id);
                $date = Carbon::parse($request->date);
                $year = $date->year;
                $data = $this->jvFuelPumpData->getData($date, $id);
                $currentSaleId = $data['sale_info']['id'];
                $exists = SaleTransaction::where('type', 'JV')->where('sale_id', $currentSaleId)->exists();

                if ($exists) {
                    //abort(403, "This Sale Transaction has already being entered");
                    throw new Exception("This Sale Transaction has already being entered");
                }


                $formData = $this->jvFuelPumpData->getFields($data, [], $data['price']);


                $selectedStation = Station::where('station_id', $request->station_id)->first();

                $projectId = $selectedStation['project_id'];

                $accounts = Account::select('Id', 'Name')->get();

                $projects = Project::select('Id', "Name")->get();
            }

            return Inertia::render('JV/Create', [
                'stations' => fn() => $stations,
                'project_id' => $projectId,
                'data' => fn() => $data,
                'year' => $year,
                'formData' => fn() => $formData,
                'projects' => fn() => $projects,
                'filters' => fn() => $request->only(['station_id', 'date', 'partial', 'year']),
                'accounts' => fn() => $accounts
            ]);

        } catch (Exception $e) {
            //dd($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }







    }
}
