<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SIVDet extends Model
{
    protected $connection = 'sqlsrv_db';

    protected $table = 'SIVDet';
    public $timestamps = false;



    protected $fillable = [
        'StockId',
        'BranchId',
        'UnitOfMeasureId',
        'AccountId',
        'CostCenterId',
        'SalesTaxRateId',
        'Quantity',
        'CostPrice',
        'SellingPrice',
        'CostValue',
        'SalesValue',
        'Reference',
        'TCYNet',
        'ExchRate',
        'TCYTax',
        'TCYDiscount',
        'OrigQuantity',
        'OrigCostPrice',
        'OrigCostValue',
        'OrigSellingPrice',
        'OrigSalesValue',
        'OrigTCYNet',
        'OrigExchRate',
        'OrigTCYTax',
        'OrigTCYDiscount',
        'AuditTrail',
        'CreatedBy',
        'DateCreated',
        'EditedBy',
        'LastEdited',
        'RV'
    ];
}
