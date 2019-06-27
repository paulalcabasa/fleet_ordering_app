<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDeliverySchedule extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_DELIVERY_SCHEDULE";
    protected $connection = "oracle";

    public function insert_delivery_schedule($params){
		$this->insert($params);
    }

    public function get_delivery_schedule($requirement_id){

        $sql = "delivery_schedule_id,
                requirement_id,
                quantity,
              	to_char(delivery_date,'MM/DD/YYYY') delivery_date";

        $params = [
            ['requirement_id' ,'=', $requirement_id]
        ];

        $data = $this
                    ->selectRaw($sql)
                    ->where($params)
                    ->get();
        return $data;

    }
}