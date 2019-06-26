<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class ModuleApproval extends Model
{
    //
    protected $table = "IPC_DMS.FS_MODULE_APPROVAL";
	protected $connection = "oracle";
	const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

	public function insert_module_approval($params){
		$this->insert($params);
    }

    public function get_projects_approval($dealer_id,$approver_id,$approver_source_id,$user_type){
    	$status = "";
    	$status_filter = "";
    	$dealer_filter = "";
    	if($user_type == "Dealer Manager"){
    		$dealer_filter = "AND fp.dealer_id = " . $dealer_id;
    		$status = "Pending";
    	}
    	else if($user_type == "Fleet Sales Staff"){
    		$status = "Pending";
    		$status_filter = "AND fp.status = 11";
    	}
    	
    	$sql = "SELECT ma.approval_id,
		            fp.project_id,
		            fc.customer_name account_name,
		            to_char(ma.creation_date,'mm/dd/yyyy HH:MI:SS AM') date_submitted,
		            fs.status_name,
		            usr.first_name || ' ' || usr.last_name created_by,
		            ma.approver_id,
		            fa.approver_user_id,
		            fa.approver_source_id,
		            usr_app.first_name || ' ' || usr_app.last_name approver_name
				FROM ipc_dms.fs_module_approval ma
				    LEFT JOIN ipc_dms.fs_projects fp
				        ON ma.module_reference_id = fp.project_id
				        AND ma.column_reference = 'project_id'
				        AND ma.table_reference = 'fs_projects'
				    LEFT JOIN ipc_dms.fs_customers fc
				        ON fp.customer_id = fc.customer_id
				    LEFT JOIN ipc_dms.fs_status fs
				        ON fs.status_id = ma.status
				    LEFT JOIN ipc_dms.ipc_portal_users_v usr
				        ON usr.user_id = fp.created_by 
				        AND usr.user_source_id = fp.create_user_source_id
				    LEFT JOIN ipc_dms.fs_approvers fa
				        ON fa.approver_id = ma.approver_id
				    LEFT JOIN ipc_dms.ipc_portal_users_v usr_app
				        ON usr_app.user_id = fa.approver_user_id
				        AND usr_app.user_source_id = fa.approver_source_id  
				WHERE 1 = 1
					$dealer_filter
					AND fa.approver_user_id = :approver_id
					AND fa.approver_source_id = :approver_source_id
			        AND fs.status_name = :status
			        $status_filter";
    /*	print_r(session('user'));
    	echo $status;
    	echo "<pre>";
    	echo $sql;
    	die;*/
		$params = [
		
			'status'             => $status,
			'approver_id'        => $approver_id,
			'approver_source_id' => $approver_source_id
		];
		$query = DB::select($sql,$params);

    	return $query;
    }

    public function save_approval(
    	$approval_id, 
    	$module_reference_id, 
    	$table_reference, 
    	$column_reference, 
    	$status, 
    	$remarks,
    	$update_user, 
    	$update_user_source
    	
    ){
    	$this
            ->where([
            	[ 'approval_id', '=' , $approval_id ],
            	[ 'module_reference_id', '=' , $module_reference_id ],
            	[ 'table_reference', '=' , $table_reference ],
            	[ 'column_reference' , '=' , $column_reference ]
            ])
            ->update([
            	'status' => $status,
            	'remarks' => $remarks,
            	'updated_by' => $update_user,
            	'update_user_source_id' => $update_user_source
            	//'update_date' => Carbon::now()
            ]);
    }

    public function get_pending_per_project($project_id,$user_type) {
    	$sql = "SELECT ma.approval_id,
                    fp.project_id,
                    fc.customer_name account_name,
                    to_char(ma.creation_date,'mm/dd/yyyy HH:MI:SS AM') date_submitted,
                    fs.status_name,
                    usr.first_name || ' ' || usr.last_name created_by,
                    ma.approver_id,
                    fa.approver_user_id,
                    fa.approver_source_id,
                    usr_app.first_name || ' ' || usr_app.last_name approver_name,
                    fa.user_type
                FROM ipc_dms.fs_module_approval ma
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON ma.module_reference_id = fp.project_id
                        AND ma.column_reference = 'project_id'
                        AND ma.table_reference = 'fs_projects'
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fp.customer_id = fc.customer_id
                    LEFT JOIN ipc_dms.fs_status fs
                        ON fs.status_id = ma.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fp.created_by 
                        AND usr.user_source_id = fp.create_user_source_id
                    LEFT JOIN ipc_dms.fs_approvers fa
                        ON fa.approver_id = ma.approver_id
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr_app
                        ON usr_app.user_id = fa.approver_user_id
                        AND usr_app.user_source_id = fa.approver_source_id  
                WHERE 1 = 1
                    AND fp.project_id = :project_id
                    AND fs.status_name = :status_name
                    AND fa.user_type = :user_type";
    	
		$params = [
			'project_id'  => $project_id,
			'status_name' => 'Pending',
			'user_type'   => $user_type
		];
		$query = DB::select($sql,$params);
    
    	return $query;
    }
}
