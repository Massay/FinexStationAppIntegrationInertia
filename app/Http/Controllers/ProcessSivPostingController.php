<?php

namespace App\Http\Controllers;

use App\Actions\FuelPump\MergePostingData;
use App\Models\AutoNum;
use App\Models\SaleTransaction;
use App\Models\SIV;
use App\Models\SIVDet;
use App\Models\Voucher;
use App\Models\VoucherDep;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessSivPostingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'batchNumber' => 'required',
            'year' => 'required',
            'date' => 'required',
            'description' => 'required',
            'postings' => 'required',
            'unitPriceAgo' => [
                'required',
                'gt:0'
            ],
            'unitPricePms' => [
                'required',
                'gt:0'
            ]
        ]);


      
        //dd(vars: $request->all());

        $postings = $request->postings;

        $mergeData = MergePostingData::merge($postings, "SIV");

        DB::transaction(function () use ($request, $mergeData) {

            $userName = auth()->user()->name;

            foreach ($mergeData as $itemArray) {

                if(floatval($itemArray[0]['amount']) <= 0){
                    continue;
                }

                $reference = AutoNum::where('Id', 'SIV')->latest('EditedBy')->first();
                $number = $reference->Prefix . ($reference->NextNum + 1);


                SaleTransaction::create([
                    'type' => 'SIV',
                    'sale_id' => $request->sale_id,
                    'source_station_id'=> $request->station_id,
                    'reference' => $number,
                    'date' => $request->date,
                    'user_id'=> auth()->id()
                ]);

                SIV::create(
                    [
                        'IsBatched' => 1,
                        'BatchNumber' => $request->batchNumber,
                        'TxDate' => Carbon::parse($request->date)->format('Y-m-d'),
                        'Descr' => $request->description,
                        'TransType' => "SCSIV",
                        'Customer' => '',
                        'CurrencyId' => 'GMD',
                        'DateCreated' => Carbon::now()->format('Y-m-d'),
                        'CreatedBy' => auth()->user()->name,
                        'FinYearId' => $request->year,
                        'BatchNumber' => $request->batchNumber,
                        'Reference' => $number
                    ]
                );

                foreach ($itemArray as $item) {

                   
                    if ($item['stock_id'] == false) {
                        continue;
                    }
                 
                    $costPrice = ($item['stock_id'] == 'PMS') ? $request['unitPricePms'] : $request['unitPriceAgo'];

                    SIVDet::create([
                        'StockId' => $item['stock_id'],
                        'AccountId' => $item['account_id'],
                        'BranchId' => $request->branch_id,
                        'Descr' => $item['description'],
                        'CostCenterId' => $request->project_id,
                        'UnitOfMeasureId' => 'LTR',
                        'SalesTaxRateId' => 'STD',
                        'Quantity' => floatval($item['amount']),
                        'CostPrice' => floatval($costPrice),
                        'SellingPrice' => 0,
                        'CostValue' => floatval($costPrice) * floatval($item['amount']),
                        'SalesValue' => 1,
                        'TCYNet' => 1,
                        'TCYTax' => 1,
                        'TCYDiscount' => 0,
                        'OrigQuantity' => 0,
                        'OrigCostPrice' => 0,
                        'OrigCostValue' => 0,
                        'OrigSellingPrice' => 0,
                        'OrigSalesValue' => 0,
                        'OrigTCYNet' => 0,
                        'OrigExchRate' => 0,
                        'OrigTCYTax' => 0,
                        'OrigTCYDiscount' => 0,
                        'CurrencyId' => 'GMD',
                        'TCYAmount' => floatval($item['amount']),
                        'ExchRate' => 1.00,
                        'LCYAmount' => floatval($item['amount']),
                        'Reference' => $number,
                        'DateCreated' => Carbon::now()->format('Y-m-d'),
                        'CreatedBy' => $userName,
                    ]);

            
                }

                $reference->NextNum = $reference->NextNum + 1;
                $reference->EditedBy = $userName;
                $reference->save();
            }


            $mergeData = [];
        });


        return to_route('siv');
        
        // dashboard
        //dd($request->all());
    }
}
