<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FPC_Item extends Model
{
	protected $table = "IPC_DMS.FS_FPC_ITEMS";
	protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

	public function insert_fpc_item($params){
		$this->insert($params);
	}

	public function get_fpc_item_requirements($fpc_id){
		$sql = "SELECT  fpc_prj.fpc_id,
				            rh.project_id,
				            fpc_prj.fpc_project_id,
				            rl.requirement_line_id,
				            rl.inventory_item_id,
				            vehicle.price
				FROM ipc_dms.fs_fpc_projects fpc_prj
				    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
				        ON fpc_prj.requirement_header_id = rh.requirement_header_id
				    LEFT JOIN ipc_dms.fs_prj_requirement_lines rl
				        ON rl.requirement_header_id = rh.requirement_header_id
				    LEFT JOIN ipc_dms.ipc_vehicles_with_price_v vehicle
				        ON vehicle.inventory_item_id = rl.inventory_item_id
				WHERE 1 = 1
				    AND fpc_prj.fpc_id = :fpc_id";

		$params = [
			'fpc_id' => $fpc_id
		];
		$query = DB::select($sql,$params);
    	return $query;
	}

	public function get_item_requirements($fpc_project_id){
		$sql = "SELECT fpc_prj.fpc_id,
						fp.project_id,
						fpc_prj.fpc_project_id,
						vehicle.sales_model,
						vehicle.color,
						rl.quantity,
						nvl(rl.BODY_BUILDER_NAME,'-') body_builder_name,
						nvl(rl.rear_body_type,'-') rear_body_type,
						nvl(rl.additional_items,'-') additional_items,
						rl.suggested_price,
						fpc_item.suggested_retail_price,
						fpc_item.wholesale_price,
						fpc_item.dealers_margin,
						fpc_item.lto_registration,
						fpc_item.fleet_price,
						rl.requirement_line_id,
                        fpc_item.fpc_item_id
                FROM ipc_dms.fs_fpc_projects fpc_prj
                    INNER JOIN IPC_DMS.fs_projects fp
                        ON fpc_prj.project_id = fp.project_id
                    INNER JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON rh.project_id = fp.project_id
                        AND rh.requirement_header_id = fpc_prj.requirement_header_id
                    INNER JOIN ipc_dms.fs_prj_requirement_lines rl
                        ON rl.requirement_header_id = rh.requirement_header_id
                    INNER JOIN ipc_dms.ipc_vehicle_models_v vehicle
                        ON vehicle.inventory_item_id = rl.inventory_item_id
                    INNER JOIN ipc_dms.fs_fpc_items fpc_item
                        ON fpc_item.requirement_line_id = rl.requirement_line_id
                        AND fpc_item.fpc_project_id = fpc_prj.fpc_project_id
                WHERE 1 = 1
                   AND fpc_prj.fpc_project_id = :fpc_project_id";

		$params = [
			'fpc_project_id' => $fpc_project_id
		];
		$query = DB::select($sql,$params);
    	return $query;
	}

    public function updateFPCItem($dealers_margin, $lto_registration, $fleet_price, $updated_by, $user_source_id, $fpc_item_id){
        $this
            ->where([
                [ 'fpc_item_id', '=' , $fpc_item_id ]
            ])
            ->update([
                'dealers_margin'   => $dealers_margin,
                'lto_registration' => $lto_registration,
                'fleet_price'      => $fleet_price,
                'updated_by'       => $updated_by,
                'update_user_source_id'   => $user_source_id,
                'fpc_item_id'      => $fpc_item_id
            ]);
    }
}
