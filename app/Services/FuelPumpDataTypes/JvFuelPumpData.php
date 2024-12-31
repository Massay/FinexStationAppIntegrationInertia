<?php

namespace App\Services\FuelPumpDataTypes;

use App\Actions\FuelPump\FuelPumpApiConnector;
use App\Contracts\PullFuelPumpDataInterface;


class JvFuelPumpData implements PullFuelPumpDataInterface
{


    public function __construct(private FuelPumpApiConnector $fuelPumpApiConnector) {}

    /**
     * @inheritDoc
     */
    public function getData($date, $stationId)
    {
        $data=  $this->fuelPumpApiConnector->getDataByStation($stationId, $date);
        return $data;
    }




    /**
     * @inheritDoc
     */
    public function getFields($data, $priceStructure, $actualPrice)
    {

        $coupon_sales = 0.0;
        $cash_sales =  0.0;
        $checks =  0.0;


        $agoAccountId  = "440200"; // 440200
        $pmsAccountId = "440100"; //440100
        $totalAccountId = "103640";


        $formData = [
            [
                'id' => 1,
                'Name' => "Cash",
                'amount' => $cash_sales,
                'pms_amount' => $cash_sales,
                'ago_amount' => $cash_sales,
                'total_account_id' => $totalAccountId,
                'ago_account_id' => $agoAccountId,
                'pms_account_id' => $pmsAccountId
            ],
            [
                'id' => 2,
                'Name' => "Coupon",
                'amount' => $coupon_sales,
                'pms_amount' => $coupon_sales,
                'ago_amount' => $coupon_sales,
                'ago_account_id' => $agoAccountId,
                'pms_account_id' => $pmsAccountId,
                'total_account_id' => $totalAccountId,
            ],
            [
                'id' => 3,
                'Name' => "Cheques",
                'amount' => $checks,
                'pms_amount' => $checks,
                'ago_amount' => $checks,
                'ago_account_id' => $agoAccountId,
                'pms_account_id' => $pmsAccountId,
                'total_account_id' => $totalAccountId,
            ]
        ];


        if (!empty($data['sales'])) {
            $coupon_sales = $data['sales']['coupon_sales'];
            $cash_sales =  $data['sales']['cash_sales'];
            $checks =  $data['sales']['checks'];

            $total_litres_sold = $data['sales']['total_litres_sold'];
            $total_pms_sold_litres = $data['sales']['total_pms_sold_litres'];
            $total_ago_sold_litres = $data['sales']['total_ago_sold_litres'];

            $cash_sales_pms = ($cash_sales > 0) ? $cash_sales *  ($total_pms_sold_litres / $total_litres_sold) * -1 : 0;
            $cash_sales_ago = ($cash_sales > 0) ? $cash_sales *  ($total_ago_sold_litres / $total_litres_sold) * -1 : 0;


            $coupon_sales_pms = ($coupon_sales > 0) ? $coupon_sales * ($total_pms_sold_litres / $total_litres_sold) * -1 : 0;

            $coupon_sales_ago = ($coupon_sales > 0) ? $coupon_sales * ($total_ago_sold_litres / $total_litres_sold) * -1 : 0;


            $checks_pms = ($checks > 0)  ? $checks * ($total_pms_sold_litres / $total_litres_sold) * -1 : 0;

            $checks_ago = ($checks > 0) ? $checks * ($total_ago_sold_litres / $total_litres_sold) * -1 : 0;

            $formData = [
                [
                    'id' => 1,
                    'Name' => "Cash",
                    'amount' => $cash_sales,
                    'pms_amount' => round($cash_sales_pms,2),
                    'ago_amount' => round($cash_sales_ago,2),
                    'total_account_id' => $totalAccountId,
                    'ago_account_id' => $agoAccountId,
                    'pms_account_id' => $pmsAccountId
                ],
                [
                    'id' => 2,
                    'Name' => "Coupon",
                    'amount' => $coupon_sales,
                    'pms_amount' => round($coupon_sales_pms,2),
                    'ago_amount' => round($coupon_sales_ago,2),
                    'ago_account_id' => $agoAccountId,
                    'pms_account_id' => $pmsAccountId,
                    'total_account_id' => "205225",
                ],
                [
                    'id' => 3,
                    'Name' => "Cheques",
                    'amount' => $checks,
                    'pms_amount' => round( $checks_pms,2),
                    'ago_amount' => round($checks_ago, 2),
                    'ago_account_id' => $agoAccountId,
                    'pms_account_id' => $pmsAccountId,
                    'total_account_id' => $totalAccountId,
                ]
            ];
        }

        return $formData;
    }
}
