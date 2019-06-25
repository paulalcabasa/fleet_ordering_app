<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemUserType extends Model
{
    protected $connection = 'oracle_portal';
    protected $table = 'ipc_portal.system_user_types';
    protected $primaryKey = 'user_type_id';
}
