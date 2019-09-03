<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $connection = 'oracle';
    protected $table = 'ipc_portal.user_logs';
    protected $primaryKey = 'log_id';

    public function insert_log($params){
        $this->insert($params);
    }

}
