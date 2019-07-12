<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Competitor extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_COMPETITORS";
    protected $connection = "oracle";
    const UPDATED_AT = 'update_date';
    const CREATED_AT = 'creation_date';

    public function insert_competitor($params){
		$this->insert($params);
    }

    public function get_competitors($project_id){
    	$sql = "SELECT fpc.competitor_id,
                        fpc.project_id,
                        fpc.brand,
                        fpc.model,
                        fpc.price,
                        vehicle.sales_model,
                        vehicle.color
				FROM ipc_dms.fs_project_competitors fpc
                    LEFT JOIN ipc_dms.ipc_vehicle_models_v vehicle
                        ON vehicle.inventory_item_id = fpc.ipc_item_id
                    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON rh.project_id = fpc.project_id 
                    LEFT JOIN ipc_dms.fs_prj_requirement_lines rl
                        ON rl.inventory_item_id = fpc.ipc_item_id
                        AND rl.
				WHERE 1 = 1
					AND fpc.project_id = :project_id";
		$params = [
			'project_id' => $project_id
		];

        $query = DB::select($sql,$params);

        return $query;
    }

    public function get_brands($brand_name){
        $query = DB::connection('oracle')
                ->table('ipc_dms.fs_competitors')
                ->selectRaw(DB::raw('distinct brand'))
                ->whereRaw("lower(brand) like '%".strtolower($brand_name)."%'")
                ->limit(10)
                ->get();
        return $query;
    }

    public function get_models($model,$brand){
        $query = DB::connection('oracle')
                ->table('ipc_dms.fs_competitors')
                ->selectRaw(DB::raw('distinct model'))
                ->whereRaw("lower(model) like '%".strtolower($model)."%'")
                ->whereRaw("brand = '" . $brand . "'")
                ->limit(10)
                ->get();
        return $query;
    }

    public function create_competitor($brand, $model, $created_by, $user_source_id, $date_created){
        $query = DB::connection('oracle')
            ->table('ipc_dms.fs_competitors')
            ->updateOrInsert(
                [
                    'brand' => $brand, 
                    'model' => $model
                ],
                [
                    'brand'                 => $brand,
                    'model'                 => $model,
                    'created_by'            => $created_by,
                    'create_user_source_id' => $user_source_id,
                    'creation_date'         => $date_created,
                    'update_user_source_id' => $user_source_id
                ]
            );
    }
}
