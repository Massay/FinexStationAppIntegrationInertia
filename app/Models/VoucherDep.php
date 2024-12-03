<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherDep extends Model
{
    protected $connection = 'sqlsrv_db';

    protected $table = 'VoucherDet';
    public $timestamps = false;

    protected $fillable = [
        'AccountId',
        'ProjectId',
        'Descr',
        'CurrencyId',
        'TCYAmount',
        'ExchRate',
        'LCYAmount',
        'Reference',
        'DateCreated',
        'CreatedBy'
    ];
}
