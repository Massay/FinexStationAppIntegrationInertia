<?php

namespace App\Http\Controllers;

use App\Actions\FuelPump\MergePostingData;
use App\Models\Account;
use App\Models\AutoNum;
use App\Models\SaleTransaction;
use App\Models\Voucher;
use App\Models\VoucherDep;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessJVPostingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $request->validate([
            'batchNumber' => 'required',
            'date' => [
                'date',
                'required'
            ],
            'year' => 'required',
            'description' => 'required',
            'postings' => [
                'required'
            ]
        ]);


        // dd($request->all());

        $postings = $request->postings;

        $mergeData = MergePostingData::merge($postings);

        // foreach ($postings as $key => $item) {
        //     $account = Account::where('Id', $item['total_account_id'])->first();

        //     if ($item['Name'] == 'Cash') {
        //         $cashData = [
        //             [
        //                 'account_id' => $item['total_account_id'],
        //                 'amount' => $item['amount'],
        //                 'description' => $account?->Name,
        //                 'currency_id' => 'GMD'
        //             ],
        //             [
        //                 'account_id' => $item['pms_account_id'],
        //                 'amount' => $item['pms_amount'],
        //                 'description' => 'PETROL',
        //                 'currency_id' => 'GMD'
        //             ],
        //             [
        //                 'account_id' => $item['ago_account_id'],
        //                 'amount' => $item['ago_amount'],
        //                 'description' => 'DIESEL',
        //                 'currency_id' => 'GMD'
        //             ]
        //         ];
        //         array_push($mergeData, $cashData);
        //     }

        //     if ($item['Name'] == 'Coupon') {
        //         $couponData = [
        //             [
        //                 'account_id' => $item['total_account_id'],
        //                 'amount' => $item['amount'],
        //                 'description' => $account?->Name,
        //                 'currency_id' => 'GMD'
        //             ],
        //             [
        //                 'account_id' => $item['pms_account_id'],
        //                 'amount' => $item['pms_amount'],
        //                 'description' => 'PETROL',
        //                 'currency_id' => 'GMD'
        //             ],
        //             [
        //                 'account_id' => $item['ago_account_id'],
        //                 'amount' => $item['ago_amount'],
        //                 'description' => 'DIESEL',
        //                 'currency_id' => 'GMD'
        //             ]
        //         ];
        //         array_push($mergeData, $couponData);
        //     }
        //     if ($item['Name'] == 'Cheques') {

        //         $checkData = [
        //             [
        //                 'account_id' => $item['total_account_id'],
        //                 'amount' => $item['amount'],
        //                 'description' => $account?->Name,
        //                 'currency_id' => 'GMD'
        //             ],
        //             [
        //                 'account_id' => $item['pms_account_id'],
        //                 'amount' => $item['pms_amount'],
        //                 'description' => 'PETROL',
        //                 'currency_id' => 'GMD'

        //             ],
        //             [
        //                 'account_id' => $item['ago_account_id'],
        //                 'amount' => $item['ago_amount'],
        //                 'description' => 'DIESEL',
        //                 'currency_id' => 'GMD'
        //             ]
        //         ];

        //         array_push($mergeData, $checkData);
        //     }
        // }

        DB::transaction(function () use ($request, $mergeData) {

            $userName = auth()->user()->name;

            $reference = AutoNum::where('Id', 'JV')->first();
            $number = $reference->Prefix . ($reference->NextNum + 1);

            // 'type','sale_id','source_station_id','reference','user_id']
            SaleTransaction::create([
                'type' => 'JV',
                'sale_id' => 1,
                'source_station_id'=> 1,
                'reference' => $number,
                'user_id'=> auth()->id()
            ]);


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
    }
}
