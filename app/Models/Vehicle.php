<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Vehicle extends Model
{
    //
	protected $table = "ipc_dms.ipc_vehicle_models_v";
	protected $connection = "oracle"; 

	public function get_vehicle_models($vehicle_type){
		$sql = "SELECT DISTINCT
			        vm.model_variant,
			        vm.sales_model
				FROM ipc_dms.ipc_vehicle_models_v vm
				WHERE 1 = 1
					AND vm.model_variant IN (
						SELECT model 
						FROM ipc_dms.fs_vehicle_groups 
						WHERE vehicle_type = :vehicle_type
					)
					AND vm.inventory_item_id NOT IN (SELECT inventory_item_id FROM ipc_dms.inactive_vehicles)
		        	AND vm.sales_model IS NOT NULL";

		$params = [
			'vehicle_type' => $vehicle_type
		];
		$query = DB::select($sql,$params);
		return $query;
	}

	public function get_model_colors($sales_model){
		$sql = "SELECT 
			        vm.inventory_item_id id,
			        vm.color text
				FROM ipc_dms.ipc_vehicle_models_v vm
				WHERE 1 = 1
					AND vm.sales_model = :sales_model
					AND vm.inventory_item_id NOT IN (SELECT inventory_item_id FROM ipc_dms.inactive_vehicles)
		        	AND vm.sales_model IS NOT NULL";
		$params = [
			'sales_model' => $sales_model
		];
		$query = DB::select($sql,$params);
		return $query;
	}
}
