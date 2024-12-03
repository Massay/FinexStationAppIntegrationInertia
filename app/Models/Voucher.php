<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $connection = 'sqlsrv_db';

    protected $table = 'Voucher';
    public $timestamps = false;

    protected $fillable = [
        'IsBatched',
        'BatchNumber',
        'Reference',
        'ChequeNo',
        'TxDate',
        'FinYearId',
        'Payee',
        'Descr',
        'Ledger',
        'TransType',
        'BankId',
        'AccountNumber',
        'RecrJnlRef',
        'CreatedBy',
        'DateCreated',
        'EditedBy',
        'LastEdited',
        'RV',
        'AuditTrail'
    ];
}
