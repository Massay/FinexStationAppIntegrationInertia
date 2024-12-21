<?php

namespace App\Services\FuelPumpDataTypes;

use App\Actions\FuelPump\FuelPumpApiConnector;
use App\Contracts\PullFuelPumpDataInterface;


class SivFuelPumpData implements PullFuelPumpDataInterface
{

    public function __construct(private FuelPumpApiConnector $fuelPumpApiConnector) {}

    /**
     * @inheritDoc
     */
    public function getData($date, $stationId)
    {
        return $this->fuelPumpApiConnector->getDataByStation($stationId, $date);
    }
    /**
     * @inheritDoc
     */
    public function getFields($data, $priceStructure, $actualPrice)
    {

        $coupon_sales = 0.0;
        $cash_sales =  0.0;
        $checks =  0.0;
        $expenses = 0;
        $generators = 0;
        $vehicles = 0;



        // Default FormData templates
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
            ],
            [
                'id' => 4,
                'Name' => "generators",
                'amount' => $generators,
                'pms_amount' => $generators,
                'ago_amount' => $generators,
                'ago_account_id' => "440200",
                'pms_account_id' => "440100",
                'total_account_id' => "103640",
            ],
            [
                'id' => 5,
                'Name' => "vehicles",
                'amount' => $vehicles,
                'pms_amount' => $vehicles,
                'ago_amount' => $vehicles,
                'ago_account_id' => "440200",
                'pms_account_id' => "440100",
                'total_account_id' => "103640",
            ],
            [
                'id' => 6,
                'Name' => "expenses",
                'amount' => $expenses,
                'pms_amount' => $expenses,
                'ago_amount' => $expenses,
                'ago_account_id' => "440200",
                'pms_account_id' => "440100",
                'total_account_id' => "103640",
            ]
        ];




        if (!empty($data['sales'])) {
            $coupon_sales = $data['sales']['coupon_sales'];
            $cash_sales =  $data['sales']['cash_sales'];
            $checks =  $data['sales']['checks'];
            $total_litres_sold = $data['sales']['total_litres_sold'];
            $total_pms_sold_litres = $data['sales']['total_pms_sold_litres'];
            $total_ago_sold_litres = $data['sales']['total_ago_sold_litres'];



            $expenses = $data['sales']['expenses'];
            $generators =  $data['sales']['generators'];
            $vehicles =  $data['sales']['vehicles'];

            $vehicles_ago = $data['sales']['vehicles_ago'];
            $vehicles_pms = $data['sales']['vehicles_pms'];


            $generators_ago = $data['sales']['generator_ago'];
            $generators_pms = $data['sales']['generator_pms'];

            $agoPrice = $priceStructure['agoPrice'];
            $pmsPrice = $priceStructure['pmsPrice'];

            $actualPmsPrice = $actualPrice['pms_price'];
            $actualAgoPrice = $actualPrice['ago_price'];
            $averagePrice = ($actualPmsPrice + $actualAgoPrice) / 2;


            $CouponPmsTotal = ($coupon_sales > 0) ? (($coupon_sales * ($total_pms_sold_litres / $total_litres_sold)) / $averagePrice) * 1 : 0;
            $CouponAgoTotal = ($coupon_sales > 0) ? (($coupon_sales * ($total_ago_sold_litres / $total_litres_sold)) / $averagePrice) * 1 : 0;
            
            $CashPmsTotal =  ($cash_sales > 0) ? (($cash_sales *  ($total_pms_sold_litres / $total_litres_sold)) / $averagePrice) * 1 : 0;
            $CashAgoTotal =  ($cash_sales > 0) ? (($cash_sales *  ($total_ago_sold_litres / $total_litres_sold)) / $averagePrice) * 1 : 0;
            
            $ChequePmsTotal =  ($checks > 0)  ? (($checks * ($total_pms_sold_litres / $total_litres_sold)) / $averagePrice) * 1 : 0;
            $ChequeAgoTotal = ($checks > 0) ? (($checks * ($total_ago_sold_litres / $total_litres_sold)) / $averagePrice) * 1 : 0;

            $GeneratorPms = ($generators_pms > 0)  ? ($generators_pms / $actualPmsPrice) * 1 : 0;
            $GeneratorAgo = ($generators_ago > 0) ? ($generators_ago / $actualAgoPrice) * 1 : 0;

            $VehiclePms = ($vehicles_pms > 0)  ? ($vehicles_pms / $actualPmsPrice) * 1 : 0;
            $VehicleAgo = ($vehicles_ago > 0) ? ($vehicles_ago / $actualAgoPrice) * 1 : 0;

            $ExpenseAgo = ($expenses > 0) ? (($expenses * ($total_ago_sold_litres / $total_litres_sold)) / $averagePrice) * 1 : 0;

            $ExpensePms = ($expenses > 0)  ? (($expenses * ($total_pms_sold_litres / $total_litres_sold)) / $averagePrice ) * 1 : 0;

            $formData = [
                [
                    'id' => 1,
                    'Name' => "Cash",
                    'amount' => round($pmsPrice * $CashPmsTotal + $agoPrice * $CashAgoTotal,2),
                    'pms_amount' => round($CashPmsTotal,2),
                    'ago_amount' => round($CashAgoTotal,2),
                    'total_account_id' => "103640",
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100"
                ],
                [
                    'id' => 2,
                    'Name' => "Coupon",
                    'amount' => round($pmsPrice * $CouponPmsTotal + $agoPrice * $CouponAgoTotal,2),
                    'pms_amount' => round($CouponPmsTotal,2),
                    'ago_amount' => round($CouponAgoTotal,2),
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "205225",
                ],
                [
                    'id' => 3,
                    'Name' => "Cheques",
                    'amount' => round($pmsPrice * $ChequePmsTotal + $agoPrice * $ChequeAgoTotal,2),
                    'pms_amount' => round($ChequePmsTotal,2),
                    'ago_amount' => round($ChequeAgoTotal,2),
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "103640",
                ],
                [
                    'id' => 4,
                    'Name' => "generators",
                    'amount' => round($pmsPrice * $GeneratorPms +  $agoPrice * $GeneratorAgo,2),
                    'pms_amount' => round($GeneratorPms,2),
                    'ago_amount' => round($GeneratorAgo,2),
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "103640",
                ],
                [
                    'id' => 5,
                    'Name' => "vehicles",
                    'amount' => round($pmsPrice * $VehiclePms +  $agoPrice * $VehicleAgo,2),
                    'pms_amount' => round($VehiclePms,2),
                    'ago_amount' => round($VehicleAgo,2),
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "103640",
                ],
                [
                    'id' => 6,
                    'Name' => "expenses",
                    'amount' => round($pmsPrice * $ExpensePms + $agoPrice * $ExpenseAgo,2),
                    'pms_amount' => round($ExpensePms,2),
                    'ago_amount' => round($ExpenseAgo,2),
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "102640",
                ]
            ];

           

           
        }

        return $formData;
    }
}
