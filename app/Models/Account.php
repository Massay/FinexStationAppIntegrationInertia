<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    //Id
    // protected $primaryKey = "Id";

    protected $connection = 'sqlsrv_db';

    protected $table = 'Account';


    protected $appends = ['full_name'];

    public function getFullNameAttribute(){
        return "{$this->Name} [{$this->Id}]";
    }
}
