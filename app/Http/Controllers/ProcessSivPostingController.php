<?php

namespace App\Http\Controllers;

use App\Actions\FuelPump\MergePostingData;
use App\Models\AutoNum;
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


            $postings = $request->postings;

            $mergeData = MergePostingData::merge($postings);

            DB::transaction(function () use ($request, $mergeData) {

                $userName = auth()->user()->name;
    
                $reference = AutoNum::where('Id', 'SIV')->latest('EditedBy')->first();
                $number = $reference->Prefix . ($reference->NextNum + 1);
    
    
                Voucher::create(
                    [
                        'IsBatched' => 1,
                        'BatchNumber' => $request->batchNumber,
                        'TxDate' => Carbon::parse($request->date)->format('Y-m-d'),
                        'Descr' => $request->description,
                        'Ledger' => "NL",
                        'TransType' => "NLJNL",
                        'DateCreated' => Carbon::now()->format('Y-m-d'),
                        'CreatedBy' => auth()->user()->name,
                        'FinYearId' => $request->year,
                        'BatchNumber' => $request->batchNumber,
                        'Reference' => $number
                    ]
                );
    
    
    
                foreach ($mergeData as $itemArray) {
    
                    foreach ($itemArray as $item) {
    
                        VoucherDep::create([
                            'AccountId' => $item['account_id'],
                            'ProjectId' => $request->project_id,
                            'Descr' => $item['description'],
                            'CurrencyId' => 'GMD',
                            'TCYAmount' => $item['amount'],
                            'ExchRate' => 1.00,
                            'LCYAmount' => $item['amount'],
                            'Reference' => $number,
                            'DateCreated' => Carbon::now()->format('Y-m-d'),
                            'CreatedBy' => $userName,
                        ]);
                    }
                }
    
                $reference->NextNum = $reference->NextNum + 1;
                $reference->EditedBy = $userName;
                $reference->save();
    
                $mergeData = [];
            });
        //dd($request->all());
    }
}
