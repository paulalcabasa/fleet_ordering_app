<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RequirementLine extends Model
{
    //
    protected $table = "IPC_DMS.FS_PRJ_REQUIREMENT_LINES";
	protected $connection = "oracle";
    const UPDATED_AT = 'update_date';
    const CREATED_AT = 'creation_date';
	public function insert_requirement_line($params){
		$id = $this->insertGetId($params,'requirement_line_id');
    	return $id;
    }

    public function get_requirement_lines($project_id){
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

    public function get_po_requirement_lines($project_id){
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
                        fpc_item.fleet_price,
                        fpc_item.suggested_retail_price,
                        fpc_item.wholesale_price,
                        fpc_item.discount,
                        fpc_item.promo,
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
                    AND rh.project_id = :project_id
                    AND fpc.status = 4
                    AND rh.status = 4";

        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function get_po_requirement_lines_v2($fpc_project_id){
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
                        fpc_item.fleet_price,
                        fpc_item.suggested_retail_price,
                        fpc_item.wholesale_price,
                        fpc_item.discount,
                        fpc_item.promo,
                        fp.dealer_id,
                        0 po_qty,
                        body_builder.description body_builder,
                        aircon.description aircon
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
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = fpc_project.project_id
                    LEFT JOIN ipc_portal.dealers dlr
                        ON dlr.cust_account_id = fp.dealer_id
                    LEFT JOIN ipc_dms.fs_body_builder_map bb_map
                        ON dlr.id = bb_map.dealer_id
                    LEFT JOIN ipc_dms.fs_value_sets body_builder
                        ON body_builder.value_set_id = bb_map.body_builder_value_set_id
                    LEFT JOIN ipc_dms.fs_value_sets aircon
                        ON aircon.value_set_id = bb_map.aircon_value_set_id
                WHERE 1 = 1
                    AND fpc_project.fpc_project_id = :fpc_project_id
                    AND fpc.status = 4
                    AND rh.status = 4";

        $params = [
            'fpc_project_id' => $fpc_project_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function deleteRequirement($requirement_line_id){
        $this->where([
            [ 'requirement_line_id', '=', $requirement_line_id ]
        ])->delete();
    }

    public function updateRequirement($params){
        $this
            ->where([
                [ 'requirement_line_id', '=' , $params['requirement_line_id'] ]
            ])
            ->update([
                'quantity'          => $params['quantity'],
                'suggested_price'   => $params['suggested_price'],
                'body_builder_name' => $params['body_builder'],
                'rear_body_type'    => $params['rear_body_type'],
                'additional_items'  => $params['additional_details']
            ]);
    }

}
