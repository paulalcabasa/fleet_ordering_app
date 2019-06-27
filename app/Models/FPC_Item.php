<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FPC_Item extends Model
{
	protected $table = "IPC_DMS.FS_FPC_ITEMS";
	protected $connection = "oracle";

	public function insert_fpc_item($params){
		$this->insert($params);
	}

	public function get_fpc_item_requirements($fpc_id){
		$sql = "SELECT fpc_prj.fpc_id,
						fp.project_id,
						fpc_prj.fpc_project_id,
						fpr.requirement_id,
						fpr.inventory_item_id,
						vehicle.price
				FROM ipc_dms.fs_fpc_projects fpc_prj
				    LEFT JOIN IPC_DMS.fs_projects fp
				        ON fpc_prj.project_id = fp.project_id
				    LEFT JOIN ipc_dms.fs_project_requirements fpr
				        ON fpr.project_id = fp.project_id
				    LEFT JOIN ipc_dms.ipc_vehicles_with_price_v vehicle
				        ON vehicle.inventory_item_id = fpr.inventory_item_id
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
						fpr.requirement_id,
						vehicle.sales_model,
						vehicle.color,
						fpr.quantity,
						FPR.BODY_BUILDER_NAME,
						fpr.rear_body_type,
						fpr.additional_items,
						fpr.suggested_price,
						fpc_item.one_price,
						fpc_item.wholesale_price,
						fpc_item.dealers_margin,
						fpc_item.lto_registration,
						fpc_item.fleet_price
				FROM ipc_dms.fs_fpc_projects fpc_prj
				    LEFT JOIN IPC_DMS.fs_projects fp
				        ON fpc_prj.project_id = fp.project_id
				    LEFT JOIN ipc_dms.fs_project_requirements fpr
				        ON fpr.project_id = fp.project_id
				    LEFT JOIN ipc_dms.ipc_vehicle_models_v vehicle
				        ON vehicle.inventory_item_id = fpr.inventory_item_id
				    LEFT JOIN ipc_dms.fs_fpc_items fpc_item
				    	ON fpc_item.requirement_id = fpr.requirement_id
				    	AND fpc_item.fpc_project_id = fpc_prj.fpc_project_id
				WHERE 1 = 1
					AND fpc_prj.fpc_project_id = :fpc_project_id";

		$params = [
			'fpc_project_id' => $fpc_project_id
		];
		$query = DB::select($sql,$params);
    	return $query;
	}
}
