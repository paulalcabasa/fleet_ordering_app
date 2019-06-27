<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FPC extends Model
{
    protected $table = "IPC_DMS.FS_FPC";
	protected $connection = "oracle";

	public function insert_fpc($params){
    	return $this->insertGetId($params,'fpc_id');
    }

    public function get_fpc($user_type){

    	$vehicle_type = "";
    	if($user_type == 32){ // lcg_value()
    		$vehicle_type = "LCV";
    	}
    	else if($user_type == 33) { // CV
    		$vehicle_type = "CV";
    	}

    	$sql = "SELECT fpc.fpc_id,
			            fc.customer_name,
			            fpc.vehicle_type,
			            fs.status_name,
			            usr.first_name || ' ' || usr.last_name created_by,
			            to_char(fpc.creation_date,'mm/dd/yyyy') date_created
				FROM ipc_dms.fs_fpc fpc
				    LEFT JOIN ipc_dms.fs_customers fc
				        ON fc.customer_id = fpc.customer_id
				    LEFT JOIN ipc_dms.fs_status fs  
				        ON fs.status_id = fpc.status
				    LEFT JOIN ipc_dms.ipc_portal_users_v usr
				        ON usr.user_id = fpc.created_by 
				        AND usr.user_source_id = fpc.create_user_source_id
				WHERE 1 = 1
					AND fpc.vehicle_type = :vehicle_type";
		$params = [
			"vehicle_type" => $vehicle_type
		];

		$query = DB::select($sql,$params);

		return $query;
    }

    public function get_details($fpc_id){

    	$sql = "SELECT fpc.fpc_id,
			            fc.customer_name,
			            fpc.vehicle_type,
			            fs.status_name,
			            usr.first_name || ' ' || usr.last_name created_by,
			            to_char(fpc.creation_date,'mm/dd/yyyy') date_created,
			            fpc.customer_id
				FROM ipc_dms.fs_fpc fpc
				    LEFT JOIN ipc_dms.fs_customers fc
				        ON fc.customer_id = fpc.customer_id
				    LEFT JOIN ipc_dms.fs_status fs  
				        ON fs.status_id = fpc.status
				    LEFT JOIN ipc_dms.ipc_portal_users_v usr
				        ON usr.user_id = fpc.created_by 
				        AND usr.user_source_id = fpc.create_user_source_id
				WHERE 1 = 1
					AND fpc.fpc_id = :fpc_id";
		$params = [
			"fpc_id" => $fpc_id
		];

		$query = DB::select($sql,$params);

		return !empty($query) ? $query[0] : $query;
    }
}