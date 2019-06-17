<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectDeliverySchedule extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_DELIVERY_SCHEDULE";
    protected $connection = "oracle";

    public function insert_delivery_schedule($params){
		$this->insert($params);
    }
}
