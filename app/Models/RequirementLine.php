<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RequirementLine extends Model
{
    //
    protected $table = "IPC_DMS.FS_PRJ_REQUIREMENT_LINES";
	protected $connection = "oracle";

	public function insert_requirement_line($params){
		$id = $this->insertGetId($params,'requirement_line_id');
    	return $id;
    }

    public function get_requirement_lines($project_id){
        $sql = "SELECT rl.requirement_line_id,
                        rh.vehicle_type,
                        vehicle.sales_model,
                        vehicle.color,
                        rl.quantity,
                        rl.suggested_price,
                        rl.body_builder_name,
                        rl.rear_body_type,
                        rl.additional_items,
                        fpc_item.fleet_price,
                        0 po_qty
                FROM ipc_dms.fs_prj_requirement_headers rh
                    LEFT JOIN ipc_dms.fs_prj_requirement_lines rl
                        ON rh.requirement_header_id = rl.requirement_header_id
                    LEFT JOIN IPC_DMS.IPC_VEHICLE_MODELS_V vehicle
                        ON vehicle.inventory_item_id = rl.inventory_item_id
                    LEFT JOIN ipc_dms.fs_fpc_items fpc_item
                        ON fpc_item.requirement_line_id = rl.requirement_line_id
                    LEFT JOIN ipc_dms.fs_fpc_projects fpc_project
                        ON fpc_project.fpc_project_id = fpc_item.fpc_project_id
                    LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_project.fpc_id
                WHERE 1 = 1
                    AND rh.project_id = :project_id";

        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

}
