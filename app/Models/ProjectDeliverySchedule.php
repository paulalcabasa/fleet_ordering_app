<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDeliverySchedule extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_DELIVERY_SCHEDULE";
    protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

    public function insert_delivery_schedule($params){
		$this->insert($params);
    }

    public function get_delivery_schedule($requirement_line_id){
        $sql = "delivery_schedule_id,
                requirement_line_id,
                quantity,
                to_char(suggested_delivery_date,'MM/DD/YYYY') suggested_delivery_date,
                to_char(delivery_date,'MM/DD/YYYY') delivery_date";

        $params = [
            ['requirement_line_id' ,'=', $requirement_line_id],
            ['module_id' ,'=', 1]
        ];
        
        $data = $this
                    ->selectRaw($sql)
                    ->where($params)
                    ->get();
        return $data;
    }

    public function get_project_delivery_schedule($requirement_line_id){

        $sql = "delivery_schedule_id,
                requirement_line_id,
                quantity,
                to_char(delivery_date,'YYYY-MM-DD') delivery_date,
                to_char(delivery_date,'MM/DD/YYYY') delivery_date_disp,
                to_char(suggested_delivery_date,'YYYY-MM-DD') suggested_delivery_date,
                to_char(suggested_delivery_date,'MM/DD/YYYY') suggested_delivery_date_disp";

        $params = [
            ['requirement_line_id' ,'=', $requirement_line_id],
            ['module_id' ,'=', 1]
        ];
        
        $data = $this
                    ->selectRaw($sql)
                    ->where($params)
                    ->get();
        return $data;
    }

    public function update_delivery_schedule(
        $suggested_delivery_date,
        $updated_by,
        $update_user_source_id,
        $requirement_line_id
    ){
        $this
            ->where([
                [ 'requirement_line_id', '=' , $requirement_line_id ]
            ])
            ->update([
                'suggested_delivery_date' => $suggested_delivery_date,
                'updated_by'              => $updated_by,
                'update_user_source_id'   => $update_user_source_id
            ]);
    }

}
