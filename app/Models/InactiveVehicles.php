<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class InactiveVehicles extends Model
{

    protected $connection = 'oracle';
    protected $table = 'ipc_dms.fs_inactive_vehicles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['inventory_item_id'];

    public function get_all_vehicles(){

		$sql = "SELECT 
					vm.inventory_item_id,
					vm.model_variant,
					vm.sales_model,
					vm.color,
					vm.prod_model,
					fvg.vehicle_type,
					CASE 
						WHEN iv.inventory_item_id IS NULL 
						THEN 'active' ELSE 'inactive' 
					END status,
					iv.id 
				FROM ipc_dms.ipc_vehicle_models_v vm       
					LEFT JOIN ipc_dms.fs_inactive_vehicles iv
						ON iv.inventory_item_id = vm.inventory_item_id    
					LEFT JOIN ipc_dms.fs_vehicle_groups fvg
				        ON fvg.model = vm.model_variant   
				WHERE 1 = 1
					AND vm.sales_model IS NOT NULL";
		$query = DB::select($sql);
		return $query;
    }
    
}
