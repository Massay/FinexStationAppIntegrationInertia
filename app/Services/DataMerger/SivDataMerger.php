<?php

namespace App\Services\DataMerger;

use App\Contracts\DataMergerInterface;
use App\Models\Account;
use App\Models\AutoNum;
use App\Models\Project;
use App\Models\SaleTransaction;
use App\Models\SIV;
use App\Models\SIVDet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SivDataMerger implements DataMergerInterface
{

    /**
     * @inheritDoc
     */
    public function merge($postings): array
    {


        $mergeData = [];

        $cashSalesName = "Cash Sales";
        $couponSalesName = "Coupon Sales";

        $chequeSaleName = "Cheque Sales";

        $generatorSalesName = "Generator Sales";

        $expenseSaleName  = "Expense Sale";


        foreach ($postings as $key => $item) {
            $account = Account::where('Id', $item['total_account_id'])->first();

            if ($item['Name'] == 'Cash') {
                $cashData = [
                    [
                        'account_id' => $item['total_account_id'],
                        'amount' => $item['amount'],
                        'description' => $account?->Name,
                        'stock_id' => false,
                        'currency_id' => 'GMD',
                        'name' => $cashSalesName
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'stock_id' => 'PMS',
                        'currency_id' => 'GMD',
                        'name' => $cashSalesName
                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'stock_id' => 'AGO',
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
                        'stock_id' => false,
                        'currency_id' => 'GMD',
                        'name' => $couponSalesName
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'stock_id' => 'PMS',
                        'currency_id' => 'GMD',
                        'name' => $couponSalesName
                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'stock_id' => 'AGO',
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
                        'stock_id' => false,
                        'description' => $account?->Name,
                        'currency_id' => 'GMD',
                        'name' => $chequeSaleName
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'stock_id' => 'PMS',
                        'currency_id' => 'GMD',
                        'name' => $chequeSaleName

                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'stock_id' => 'AGO',
                        'currency_id' => 'GMD',
                        'name' => $chequeSaleName
                    ]
                ];

                array_push($mergeData, $checkData);
            }

            //generator
            if ($item['Name'] == 'generators') {

                $checkData = [
                    [
                        'account_id' => $item['total_account_id'],
                        'amount' => $item['amount'],
                        'stock_id' => false,
                        'description' => $account?->Name,
                        'currency_id' => 'GMD',
                        'name' => $generatorSalesName
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'stock_id' => 'PMS',
                        'currency_id' => 'GMD',
                        'name' => $generatorSalesName

                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'stock_id' => 'AGO',
                        'currency_id' => 'GMD',
                        'name' => $generatorSalesName
                    ]
                ];

                array_push($mergeData, $checkData);
            }

            //Vehicles
            if ($item['Name'] == 'vehicles') {

                $checkData = [
                    [
                        'account_id' => $item['total_account_id'],
                        'amount' => $item['amount'],
                        'description' => $account?->Name,
                        'stock_id' => false,
                        'currency_id' => 'GMD',
                        'name' => 'vehicles Usage'
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'stock_id' => 'PMS',
                        'currency_id' => 'GMD',
                        'name' => 'vehicles Usage'

                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'stock_id' => 'AGO',
                        'currency_id' => 'GMD',
                        'name' => 'vehicles Usage'
                    ]
                ];

                array_push($mergeData, $checkData);
            }


            //Expense
            if ($item['Name'] == 'expenses') {

                $checkData = [
                    [
                        'account_id' => $item['total_account_id'],
                        'amount' => $item['amount'],
                        'stock_id' => false,
                        'description' => $account?->Name,
                        'currency_id' => 'GMD',
                        'name' => $expenseSaleName
                    ],
                    [
                        'account_id' => $item['pms_account_id'],
                        'amount' => $item['pms_amount'],
                        'description' => 'PETROL',
                        'stock_id' => 'PMS',
                        'currency_id' => 'GMD',
                        'name' => $expenseSaleName

                    ],
                    [
                        'account_id' => $item['ago_account_id'],
                        'amount' => $item['ago_amount'],
                        'description' => 'DIESEL',
                        'stock_id' => 'AGO',
                        'currency_id' => 'GMD',
                        'name' => $expenseSaleName
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
            DB::transaction(function () use ($request, $mergeData, $project) {

                $userName = auth()->user()->name;

                foreach ($mergeData as $itemArray) {

                    if (floatval($itemArray[0]['amount']) <= 0) {
                        continue;
                    }


                    $currentStockName = $itemArray[0]['name'];

                    $reference = AutoNum::where('Id', 'SIV')->latest('EditedBy')->first();
                    $number = $reference->Prefix . ($reference->NextNum + 1);


                    SaleTransaction::create([
                        'type' => 'SIV',
                        'sale_id' => $request->sale_id,
                        'source_station_id' => $request->station_id,
                        'reference' => $number,
                        'date' => $request->date,
                        'user_id' => auth()->id()
                    ]);
//Stock sales @ $project->Name IRO {$currentStockName} ($request->description)
                    SIV::create(
                        [
                            'IsBatched' => 1,
                            'BatchNumber' => $request->batchNumber,
                            'TxDate' => Carbon::parse($request->date)->format('Y-m-d'),
                            'Descr' => " Stock Sold @ $project->Name in Respect to Cash, Coupon, Cheque, Vehicle and Generator Ref: ($request->description)",
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
                            'CreatedBy' => $userName
                        ]);
                    }

                    $reference->NextNum = $reference->NextNum + 1;
                    $reference->EditedBy = $userName;
                    $reference->save();
                }

                $mergeData = [];
            });



        } catch (\Throwable $e) {
            echo "Failed to create records: " . $e->getMessage();
        }
    }
}
