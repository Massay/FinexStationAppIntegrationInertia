<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $connection = 'sqlsrv_db';

    protected $table = 'Project';
}
