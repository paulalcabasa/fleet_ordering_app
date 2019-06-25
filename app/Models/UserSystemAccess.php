<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSystemAccess extends Model
{
    protected $connection = 'oracle_portal';
    protected $table = 'ipc_portal.user_system_access';
    protected $primaryKey = 'access_id';

    public function user_type()
    {
        return $this->hasOne('App\SystemUserType', 'user_type_id', 'user_type_id');
    }
}