<?php

namespace App\Actions\FuelPump;

use App\Models\Account;

class MergePostingData
{
    public static function merge($postings, $type = "JV")
    {


        $mergeData = [];

        if ($type == "SIV") {

            foreach ($postings as $key => $item) {
                $account = Account::where('Id', $item['total_account_id'])->first();


                
                if ($item['Name'] == 'Cash') {
                    $cashData = [
                        [
                            'account_id' => $item['total_account_id'],
                            'amount' => $item['amount'],
                            'description' => $account?->Name,
                            'stock_id' => false,
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'stock_id' => 'PMS',
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'stock_id' => 'AGO',
                            'currency_id' => 'GMD'
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
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'stock_id' => 'PMS',
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'stock_id' => 'AGO',
                            'currency_id' => 'GMD'
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
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'stock_id' => 'PMS',
                            'currency_id' => 'GMD'

                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'stock_id' => 'AGO',
                            'currency_id' => 'GMD'
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
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'stock_id' => 'PMS',
                            'currency_id' => 'GMD'

                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'stock_id' => 'AGO',
                            'currency_id' => 'GMD'
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
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'stock_id' => 'PMS',
                            'currency_id' => 'GMD'

                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'stock_id' => 'AGO',
                            'currency_id' => 'GMD'
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
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'stock_id' => 'PMS',
                            'currency_id' => 'GMD'

                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'stock_id' => 'AGO',
                            'currency_id' => 'GMD'
                        ]
                    ];

                    array_push($mergeData, $checkData);
                }
            }
        } else {
            foreach ($postings as $key => $item) {
                $account = Account::where('Id', $item['total_account_id'])->first();

                if ($item['Name'] == 'Cash') {
                    $cashData = [
                        [
                            'account_id' => $item['total_account_id'],
                            'amount' => $item['amount'],
                            'description' => $account?->Name,
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'currency_id' => 'GMD'
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
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'currency_id' => 'GMD'
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
                            'currency_id' => 'GMD'
                        ],
                        [
                            'account_id' => $item['pms_account_id'],
                            'amount' => $item['pms_amount'],
                            'description' => 'PETROL',
                            'currency_id' => 'GMD'

                        ],
                        [
                            'account_id' => $item['ago_account_id'],
                            'amount' => $item['ago_amount'],
                            'description' => 'DIESEL',
                            'currency_id' => 'GMD'
                        ]
                    ];

                    array_push($mergeData, $checkData);
                }
            }
        }



        return $mergeData;
    }


    
}
