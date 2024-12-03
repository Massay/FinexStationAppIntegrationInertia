<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    protected $connection = 'sqlsrv_db';

    protected $table = 'Users';
}
