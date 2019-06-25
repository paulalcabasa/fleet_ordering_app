<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'oracle_portal';
    protected $table = 'ipc_portal.users';
    protected $primaryKey = 'user_id';

    public function user_details()
    {
        return $this->hasOne('App\UserDetail', 'user_id', 'user_id');
    }

    public function user_access()
    {
        return $this->hasOne('App\UserSystemAccess', 'user_id', 'user_id')->where('system_id', config('app.system_id'));
    }

    public function status()
    {
        return $this->hasOne('App\Status', 'status_id', 'status_id');
    }
}