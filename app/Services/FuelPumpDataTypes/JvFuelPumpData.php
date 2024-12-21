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


        if (!empty($data['sales'])) {
            $coupon_sales = $data['sales']['coupon_sales'];
            $cash_sales =  $data['sales']['cash_sales'];
            $checks =  $data['sales']['checks'];

            $total_litres_sold = $data['sales']['total_litres_sold'];
            $total_pms_sold_litres = $data['sales']['total_pms_sold_litres'];
            $total_ago_sold_litres = $data['sales']['total_ago_sold_litres'];

            $formData = [
                [
                    'id' => 1,
                    'Name' => "Cash",
                    'amount' => $cash_sales,
                    'pms_amount' => ($cash_sales > 0) ? $cash_sales *  ($total_pms_sold_litres / $total_litres_sold) * -1 : 0,
                    'ago_amount' => ($cash_sales > 0) ? $cash_sales *  ($total_ago_sold_litres / $total_litres_sold) * -1 : 0,
                    'total_account_id' => "103640",
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100"
                ],
                [
                    'id' => 2,
                    'Name' => "Coupon",
                    'amount' => $coupon_sales,
                    'pms_amount' => ($coupon_sales > 0) ? $coupon_sales * ($total_pms_sold_litres / $total_litres_sold) * -1 : 0,
                    'ago_amount' => ($coupon_sales > 0) ? $coupon_sales * ($total_ago_sold_litres / $total_litres_sold) * -1 : 0,
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "205225",
                ],
                [
                    'id' => 3,
                    'Name' => "Cheques",
                    'amount' => $checks,
                    'pms_amount' => ($checks > 0)  ? $checks * ($total_pms_sold_litres / $total_litres_sold) * -1 : 0,
                    'ago_amount' => ($checks > 0) ? $checks * ($total_ago_sold_litres / $total_litres_sold) * -1 : 0,
                    'ago_account_id' => "440200",
                    'pms_account_id' => "440100",
                    'total_account_id' => "103640",
                ]
            ];
        }

        return $formData;
    }
}
