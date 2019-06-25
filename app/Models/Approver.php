<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
				])->get();
		}
		else if($user_type == "IPC_STAFF") {
			$approvers = $this
				->select('approver_id','hierarchy')
				->where([
					['user_type', '=', $user_type],
					['vehicle_type', '=', $vehicle_type],
					['status_id', '=', 1],
				])->get();
		}
		return $approvers;
    }


}
