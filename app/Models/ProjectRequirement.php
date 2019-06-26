<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProjectRequirement extends Model
{
    
    protected $table = "IPC_DMS.FS_PROJECT_REQUIREMENTS";
    protected $connection = "oracle";

    public function insert_requirement($params){
		$id = $this->insertGetId($params,'requirement_id');
    	return $id;
    }

    public function get_requirement($project_id){
    	$sql = "SELECT fpr.requirement_id,
				        vehicle.sales_model,
				        vehicle.color,
				        fpr.quantity,
				        fpr.suggested_price,
				        0 po_quantity,
				        fpr.body_builder_name,
				        fpr.rear_body_type,
				        fpr.additional_items
				FROM ipc_dms.fs_project_requirements fpr
				    LEFT JOIN ipc_dms.ipc_vehicle_models_v vehicle
				        ON fpr.inventory_item_id  = vehicle.inventory_item_id
				WHERE fpr.project_id = :project_id";
		$params = [
			'project_id' => $project_id
 		];
 		$query = DB::select($sql,$params);
 		return $query;
    }
}
