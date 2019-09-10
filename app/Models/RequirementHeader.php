<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RequirementHeader extends Model
{
    //
	protected $table = "IPC_DMS.FS_PRJ_REQUIREMENT_HEADERS";
	protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

	public function insert_requirement_header($params){
		$id = $this->insertGetId($params,'requirement_header_id');
    	return $id;
    }

    public function get_requirements($project_id){
        $sql = "SELECT rl.requirement_line_id,
                        rh.vehicle_type,
                        vehicle.sales_model,
                        vehicle.color,
                        vehicle.model_variant,
                        rl.quantity,
                        rl.suggested_price,
                        rl.body_builder_name,
                        rl.rear_body_type,
                        rl.additional_items,
                        rl.inventory_item_id,
                        nvl(
                            SUM( 
                                CASE 
                                    WHEN ph.status = 10 THEN pl.po_quantity 
                                    ELSE 0 
                                END
                            ),0
                        ) po_qty
                FROM ipc_dms.fs_prj_requirement_headers rh
                    INNER JOIN ipc_dms.fs_prj_requirement_lines rl
                        ON rh.requirement_header_id = rl.requirement_header_id
                    INNER JOIN IPC_DMS.IPC_VEHICLE_MODELS_V vehicle
                        ON vehicle.inventory_item_id = rl.inventory_item_id
                    LEFT JOIN ipc_dms.fs_po_lines pl
                        ON pl.requirement_line_id = rl.requirement_line_id
                    LEFT JOIN ipc_dms.fs_po_headers ph
                        ON ph.po_header_id = ph.po_header_id
                WHERE 1 = 1
                    AND rh.project_id = :project_id
                 GROUP BY rl.requirement_line_id,
                        rh.vehicle_type,
                        vehicle.sales_model,
                        vehicle.color,
                        rl.quantity,
                        rl.suggested_price,
                        rl.body_builder_name,
                        rl.rear_body_type,
                        rl.additional_items,
                        vehicle.model_variant,
                        rl.inventory_item_id";

        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }
    
    public function get_headers($project_id){

        $sql = "SELECT rh.requirement_header_id,
                        rh.vehicle_type,
                        rh.project_id
                FROM ipc_dms.fs_prj_requirement_headers rh
                WHERE rh.project_id = :project_id";

        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);

        return $query;
    }

    public function update_status($project_id,$status,$vehicle_type,$update_user,$update_user_source){
        $this
            ->where([
                [ 'project_id', '=' , $project_id ],
                [ 'vehicle_type', '=' , $vehicle_type ]
            ])
            ->update([
                'status'                => $status,
                'updated_by'            => $update_user,
                'update_user_source_id' => $update_user_source
            ]);
    }
}
