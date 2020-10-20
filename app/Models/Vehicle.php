<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Vehicle extends Model
{
    //
	protected $table = "ipc_dms.ipc_vehicles_with_price_v";
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
					
		        	AND vm.sales_model IS NOT NULL";
		// AND vm.inventory_item_id NOT IN (SELECT inventory_item_id FROM ipc_dms.inactive_vehicles)
		$params = [
			'vehicle_type' => $vehicle_type
		];
		$query = DB::select($sql,$params);
		return $query;
	}

	public function get_vehicles(){
		// ipc_vehicles_with_price_v - with price
		// no price
		$sql = "SELECT DISTINCT
			            vm.model_variant,
			            vm.sales_model,
			            fvg.vehicle_type
				FROM ipc_dms.ipc_vehicle_models_v vm 
				    INNER JOIN ipc_dms.fs_vehicle_groups fvg
				        ON fvg.model = vm.model_variant
				WHERE 1 = 1
				  
				    AND vm.sales_model IS NOT NULL
				ORDER BY vm.model_variant ASC";
		$query = DB::select($sql);
		return $query;
	}

	public function get_model_colors($sales_model){
		/* ipc_vehicles_with_price_v */
		$sql = "SELECT 
			        vm.inventory_item_id id,
			        vm.color text
				FROM ipc_dms.ipc_vehicle_models_v vm
				WHERE 1 = 1
					AND vm.sales_model = :sales_model
				
		        	AND vm.sales_model IS NOT NULL";
		$params = [
			'sales_model' => $sales_model
		];
		$query = DB::select($sql,$params);
		return $query;
	}

	public function get_vehicles_with_price(){
		// ipc_vehicles_with_price_v - with price
		// no price
		$sql = "SELECT DISTINCT
			            vm.model_variant,
			            vm.sales_model,
			            fvg.vehicle_type
				FROM ipc_dms.IPC_VEHICLES_PRICE_ALL_V vm 
				    INNER JOIN ipc_dms.fs_vehicle_groups fvg
				        ON fvg.model = vm.model_variant
				WHERE 1 = 1
				    AND vm.sales_model IS NOT NULL
				ORDER BY vm.model_variant ASC";
		$query = DB::select($sql);
		return $query;
	}

	public function get_model_colors_with_price($sales_model){
		/* ipc_vehicles_with_price_v */
		$sql = "SELECT 
					vm.inventory_item_id,
					vm.color,
					vm.price,
					nvl(spm.floor_subsidy,0) floor_subsidy
				FROM ipc_dms.IPC_VEHICLES_PRICE_ALL_V vm 
					LEFT JOIN IPC.IPC_SP_SALES_PROMO spm
						ON vm.sales_model = spm.sales_model
						AND spm.month_promo = EXTRACT(month FROM sysdate)
						AND spm.year_promo = EXTRACT(year FROM sysdate)
				WHERE 1 = 1
					AND vm.sales_model = :sales_model
					AND vm.sales_model IS NOT NULL";
		$params = [
			'sales_model' => $sales_model
		];
		$query = DB::select($sql,$params);
		return $query;
	}

	public function get_active_vehicles(){
		/* ipc_vehicles_with_price_v */
		$sql = "SELECT 
					vm.inventory_item_id,
					vm.model_variant,
					vm.sales_model,
					vm.color,
					vm.vehicle_type,
					vm.vehicle_source_id
				FROM ipc_dms.ipc_fros_vehicles_v vm       
					LEFT JOIN ipc_dms.fs_inactive_vehicles iv
						ON iv.inventory_item_id = vm.inventory_item_id   
				WHERE 1 = 1
					AND vm.sales_model IS NOT NULL
					AND iv.inventory_item_id IS NULL";
		$query = DB::select($sql);
		return $query;
	}

	
}
