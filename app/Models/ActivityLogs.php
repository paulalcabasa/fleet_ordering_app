<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
	protected $table = "IPC_DMS.FS_ACTIVITY_LOGS";
    protected $connection = "oracle";

    public function insert_log($params){
		$this->insert($params);
    }
}
