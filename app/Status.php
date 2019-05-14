<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $connection = 'oracle_portal';
    protected $table = 'ipc_portal.status';
    protected $primaryKey = 'status_id';
}
