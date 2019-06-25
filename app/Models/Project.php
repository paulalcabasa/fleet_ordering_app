<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Project extends Model
{
    protected $table = "IPC_DMS.FS_PROJECTS";
	protected $connection = "oracle";
	const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    
	public function insert_project($params){
    	$id = $this->insertGetId($params,'project_id');
    	return $id;
    }

    public function get_projects($user_type,$dealer_id){
    	$sql = "SELECT fs.project_id,
			            fs.customer_id,
			            fc.customer_name,
			            dlr.account_name,
			            st.status_name,
			            usr.first_name || ' ' || usr.last_name created_by,
			            to_char(fs.creation_date,'mm/dd/yyyy') date_created,
			            fs.dealer_id 
				FROM ipc_dms.fs_projects fs
			        LEFT JOIN ipc_dms.fs_customers fc
			            ON fs.customer_id = fc.customer_id 
			        LEFT JOIN ipc_dms.dealers_v dlr
			            ON dlr.cust_account_id = fs.dealer_id
			        LEFT JOIN ipc_dms.fs_status st
			            ON st.status_id = fs.status
			        LEFT JOIN ipc_dms.ipc_portal_users_v usr
			            ON usr.user_id = fs.created_by 
			            AND usr.user_source_id = fs.create_user_source_id
				WHERE 1 = 1";
    	if(in_array($user_type,array('Dealer Staff','Dealer Manager'))) {
    		$sql .= " AND fs.dealer_id = :dealer_id";
    		$params = [
    			'dealer_id' => $dealer_id
    		];
    		$query = DB::select($sql,$params);
    	}
    	else {
    		$query = DB::select($sql);
    	}
    	return $query;
    }

    public function update_status($project_id,$status_id,$update_user,$update_user_source){
    	$this
            ->where([
            	[ 'project_id', '=' , $project_id ]
            ])
            ->update([
            	'status' => $status_id,
            	'updated_by' => $update_user,
            	'update_user_source_id' => $update_user_source
            ]);
    }
}
