<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Approver extends Model
{
    protected $table = "IPC_DMS.FS_APPROVERS";
    protected $connection = "oracle";

    public function get_project_approvers($requestor_user_id,$user_type,$vehicle_type){

    	if($user_type == "DLR_MANAGER"){
			$approvers = $this
				->select('approver_id','hierarchy')
				->where([
					['requestor_user_id', '=', $requestor_user_id],
					['user_type', '=', $user_type],
					['status_id', '=', 1],
                    ['module_code', '=', 'PRJ'] 
				])->get();
		}
		else if($user_type == "IPC_STAFF") {
			$approvers = $this
				->select('approver_id','hierarchy')
				->where([
					['user_type', '=', $user_type],
					['vehicle_type', '=', $vehicle_type],
					['status_id', '=', 1],
                    ['module_code', '=', 'PRJ']
				])->get();
		}
		return $approvers;
    }

    public function get_fpc_signatories($vehicle_type){
        $sql = "SELECT usr.first_name,
                        usr.middle_name,
                        usr.last_name,
                        fa.user_type,
                        fa.vehicle_type,
                        usr.position_title,
                        usr.nickname,
                        usr.name_prefix
                FROM ipc_dms.fs_approvers fa
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = fa.approver_user_id
                        AND fa.approver_source_id = usr.user_source_id
                WHERE 1 = 1
                    AND fa.user_type IN ('IPC_MANAGER','IPC_SUPERVISOR','IPC_EXPAT')
                    AND fa.vehicle_type = :vehicle_type
                    AND fa.status_id = 1";
        $params = [
            'vehicle_type' => $vehicle_type
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function get_po_approvers($vehicle_type){
        $query = $this
            ->select('approver_id','hierarchy')
            ->where([
                ['user_type', '=', 'IPC_STAFF'],
                ['vehicle_type', '=', $vehicle_type],
                ['status_id', '=', 1],
                ['module_code', '=', 'PO']
            ])->get();
      
        return $query;
    }

}
