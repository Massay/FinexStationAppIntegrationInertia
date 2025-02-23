<?php

namespace App\Services\DataMerger;

use App\Contracts\DataMergerInterface;
use App\Models\Account;
use App\Models\AutoNum;
use App\Models\Project;
use App\Models\SaleTransaction;
use App\Models\Voucher;
use App\Models\VoucherDep;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JvDataMerger implements DataMergerInterface
{

    /**
     * @inheritDoc
     */
    public function merge($postings): array
    {

        $mergeData = [];

        $cashSalesName  = 'cash sales';

        $couponSalesName = "Coupon Sales";

        $chequeSaleName = "Cheque Sales";

        foreach ($postings as $key => $item) {


            //Added to check if it will stop allowing Amounts less than 0
            if (floatval($item['amount']) <= 0) {
                continue;
            }
            $account = Account::where('Id', $item['total_account_id'])->first();

            if ($item['Name'] == 'Cash') {
                $cashData = [
                    [
                        'account_id' => $item['total_account_id'],
                        'amount' => $item['amount'],
                        'description' => $account?->Name,
                        'currency_id' => 'GMD',
                        'name' => $cashSalesName
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'currency_id' => 'GMD',
                        'name' => $cashSalesName
                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'currency_id' => 'GMD',
                        'name' => $cashSalesName
                    ]
                ];
                array_push($mergeData, $cashData);
            }

            if ($item['Name'] == 'Coupon') {
                $couponData = [
                    [
                        'account_id' => $item['total_account_id'],
                        'amount' => $item['amount'],
                        'description' => $account?->Name,
                        'currency_id' => 'GMD',
                        'name' => $couponSalesName
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'currency_id' => 'GMD',
                        'name' => $couponSalesName
                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'currency_id' => 'GMD',
                        'name' => $couponSalesName
                    ]
                ];
                array_push($mergeData, $couponData);
            }
            if ($item['Name'] == 'Cheques') {

                $checkData = [
                    [
                        'account_id' => $item['total_account_id'],
                        'amount' => $item['amount'],
                        'description' => $account?->Name,
                        'currency_id' => 'GMD',
                        'name' => $chequeSaleName
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'currency_id' => 'GMD',
                        'name' => $chequeSaleName

                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'currency_id' => 'GMD',
                        'name' => $chequeSaleName
                    ]
                ];

                array_push($mergeData, $checkData);
            }
        }


        return $mergeData;
    }
    /**
     * @inheritDoc
     */
    public function post($request, $mergeData)
    {

        $project = Project::where("Id", $request->project_id)->first();



        try {

            DB::beginTransaction();


                $userName = auth()->user()->name;
                $reference = AutoNum::where('Id', 'JV')->first();
                $number = $reference->Prefix . ($reference->NextNum + 1);


                $sale = SaleTransaction::create([
                    'type' => 'JV',
                    'sale_id' => $request->sale_id,
                    'source_station_id' => $request->station_id,
                    'reference' => $number,
                    'date' => $request->date,
                    'user_id' => auth()->id()

                ]);

               $voucher =  Voucher::create(
                    [
                        'IsBatched' => 1,
                        'BatchNumber' => $request->batchNumber,
                        'TxDate' => Carbon::parse($request->date)->format('Y-m-d'),
                        'Descr' => " Cash Coupon and Cheque sales @ $project->Name Ref: ($request->description)",
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
        //    });
        DB::commit();

        return [
            'status' => true,
        ];

        } catch (\Throwable $e) {

            DB::rollBack();

            return [
                'status' => false,
                'error' => $e->getCode() . " Failed to create records: " . $e->getMessage(),
            ];

        }
    }
}
