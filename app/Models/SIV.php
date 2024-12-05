<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SIV extends Model
{
    protected $connection = 'sqlsrv_db';

    protected $table = 'SIV';
    public $timestamps = false;

    protected $fillable = [
        'IsBatched',
        'BatchNumber',
        'Reference',
        'TxDate',
        'RequisitionId',
        'Descr',
        'Customer',
        'TransType',
        'CurrencyId',
        'CreatedBy',
        'DateCreated',
        'EditedBy',
        'LastEdited',
        'RV',
        'AuditTrail'
    ];
}
