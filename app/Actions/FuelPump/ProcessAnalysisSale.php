<?php

namespace App\Actions\FuelPump;


class ProcessAnalysisSale
{
    public static function process($data, $type = "JV")
    {



        $coupon_sales = 0.0;
        $cash_sales =  0.0;
        $checks =  0.0;
        $formData = [
            [
                'id' => 1,
                'Name' => "Cash",
                'amount' => $cash_sales,
                'pms_amount' => $cash_sales,
                'ago_amount' => $cash_sales,
                'total_account_id' => "103640",
                'ago_account_id' => "440200",
                'pms_account_id' => "440100"
            ],
            [
                'id' => 2,
                'Name' => "Coupon",
                'amount' => $coupon_sales,
                'pms_amount' => $coupon_sales,
                'ago_amount' => $coupon_sales,
                'ago_account_id' => "440200",
                'pms_account_id' => "440100",
                'total_account_id' => "103640",
            ],
            [
                'id' => 3,
                'Name' => "Cheques",
                'amount' => $checks,
                'pms_amount' => $checks,
                'ago_amount' => $checks,
                'ago_account_id' => "440200",
                'pms_account_id' => "440100",
                'total_account_id' => "103640",
            ]
        ];

        if ($type == "SIV") {

            $expenses = 0;
            $generators = 0;
            $vehicles = 0;

            $formData[] = [
                'id' => 4,
                'Name' => "generators",
                'amount' => $generators,
                'pms_amount' => $generators,
                'ago_amount' => $generators,
                'ago_account_id' => "440200",
                'pms_account_id' => "440100",
                'total_account_id' => "103640",
            ];

            $formData[] = [
                'id' => 5,
                'Name' => "vehicles",
                'amount' => $vehicles,
                'pms_amount' => $vehicles,
                'ago_amount' => $vehicles,
                'ago_account_id' => "440200",
                'pms_account_id' => "440100",
                'total_account_id' => "103640",
            ];

            $formData[] = [
                'id' => 6,
                'Name' => "expenses",
                'amount' => $expenses,
                'pms_amount' => $expenses,
                'ago_amount' => $expenses,
                'ago_account_id' => "440200",
                'pms_account_id' => "440100",
                'total_account_id' => "103640",
            ];
        }
        if (!empty($data['sales'])) {
            $coupon_sales = $data['sales']['coupon_sales'];
            $cash_sales =  $data['sales']['cash_sales'];
            $checks =  $data['sales']['checks'];

            $total_litres_sold = $data['sales']['total_litres_sold'];
            $total_pms_sold_litres = $data['sales']['total_pms_sold_litres'];
            $total_ago_sold_litres = $data['sales']['total_ago_sold_litres'];

            if($type == "SIV"){

                $expenses = $data['sales']['expenses'];
                $generators =  $data['sales']['generators'];
                $vehicles =  $data['sales']['vehicles'];

                $vehicles_ago = $data['sales']['vehicles_ago'];
                $vehicles_pms = $data['sales']['vehicles_pms'];


                $generators_ago = $data['sales']['generator_ago'];
                $generators_pms = $data['sales']['generator_pms'];

                $agoPrice = 80;
                $pmsPrice = 81;
                $averagePrice = ($agoPrice + $pmsPrice)/2;  


                $formData = [
                    [
                        'id' => 1,
                        'Name' => "Cash",
                        'amount' => $cash_sales,
                        'pms_amount' => number_format(($cash_sales > 0) ? ($cash_sales *  ($total_pms_sold_litres / $total_litres_sold)) / $averagePrice * -1 : 0,2),
                        'ago_amount' => number_format( ($cash_sales > 0) ? ($cash_sales *  ($total_ago_sold_litres / $total_litres_sold)) / $averagePrice * -1 : 0, 2),
                        'total_account_id' => "103640",
                        'ago_account_id' => "440200",
                        'pms_account_id' => "440100"
                    ],
                    [
                        'id' => 2,
                        'Name' => "Coupon",
                        'amount' => $coupon_sales,
                        'pms_amount' => number_format(($coupon_sales > 0) ? ($coupon_sales * ($total_pms_sold_litres / $total_litres_sold)) / $averagePrice * -1 : 0,2),
                        'ago_amount' => number_format(($coupon_sales > 0) ? ($coupon_sales * ($total_ago_sold_litres / $total_litres_sold)) / $averagePrice * -1 : 0,2),
                        'ago_account_id' => "440200",
                        'pms_account_id' => "440100",
                        'total_account_id' => "205225",
                    ],
                    [
                        'id' => 3,
                        'Name' => "Cheques",
                        'amount' => $checks,
                        'pms_amount' =>number_format( ($checks > 0)  ? ($checks * ($total_pms_sold_litres / $total_litres_sold)) /$averagePrice * -1 : 0,2),
                        'ago_amount' => number_format(($checks > 0) ? ($checks * ($total_ago_sold_litres / $total_litres_sold) ) /$averagePrice * -1 : 0,2),
                        'ago_account_id' => "440200",
                        'pms_account_id' => "440100",
                        'total_account_id' => "103640",
                    ]
                ];

                $formData[] = [
                    'id' => 4,
                    'Name' => "generators",
                    'amount' => $generators,
                    'pms_amount' => number_format(($generators_pms > 0)  ? ($generators_pms / $pmsPrice) * -1 : 0,2),
                    'ago_amount' => number_format(($generators_ago > 0) ? ($generators_ago / $agoPrice) * -1 : 0,2),
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "103640",
                ];

                $formData[] = [
                    'id' => 5,
                    'Name' => "vehicles",
                    'amount' => $vehicles,
                    'pms_amount' => number_format(($vehicles_pms > 0)  ? ($vehicles_pms / $pmsPrice) * -1 : 0,2),
                    'ago_amount' => number_format(($vehicles_ago > 0) ? ($vehicles_ago / $agoPrice) * -1 : 0,2),
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "103640",
                ];

                $formData[] = [
                    'id' => 6,
                    'Name' => "expenses",
                    'amount' => $expenses,
                    'pms_amount' => number_format(($expenses > 0)  ? $expenses * ($total_pms_sold_litres / $total_litres_sold) * -1 : 0,2),
                    'ago_amount' => number_format(($expenses > 0) ? $expenses * ($total_ago_sold_litres / $total_litres_sold) * -1 : 0,2),
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "103640",
                ];


            }else{
                $formData = [
                    [
                        'id' => 1,
                        'Name' => "Cash",
                        'amount' => $cash_sales,
                        'pms_amount' => number_format(($cash_sales > 0) ? $cash_sales *  ($total_pms_sold_litres / $total_litres_sold) * -1 : 0,2),
                        'ago_amount' => number_format(($cash_sales > 0) ? $cash_sales *  ($total_ago_sold_litres / $total_litres_sold) * -1 : 0,2),
                        'total_account_id' => "103640",
                        'ago_account_id' => "440200",
                        'pms_account_id' => "440100"
                    ],
                    [
                        'id' => 2,
                        'Name' => "Coupon",
                        'amount' => $coupon_sales,
                        'pms_amount' => number_format(($coupon_sales > 0) ? $coupon_sales * ($total_pms_sold_litres / $total_litres_sold) * -1 : 0,2),
                        'ago_amount' => number_format(($coupon_sales > 0) ? $coupon_sales * ($total_ago_sold_litres / $total_litres_sold) * -1 : 0,2),
                        'ago_account_id' => "440200",
                        'pms_account_id' => "440100",
                        'total_account_id' => "205225",
                    ],
                    [
                        'id' => 3,
                        'Name' => "Cheques",
                        'amount' => $checks,
                        'pms_amount' => number_format(($checks > 0)  ? $checks * ($total_pms_sold_litres / $total_litres_sold) * -1 : 0,2),
                        'ago_amount' => number_format(($checks > 0) ? $checks * ($total_ago_sold_litres / $total_litres_sold) * -1 : 0,2),
                        'ago_account_id' => "440200",
                        'pms_account_id' => "440100",
                        'total_account_id' => "103640",
                    ]
                ];
            }

            



        }


        return $formData;
    }
}
