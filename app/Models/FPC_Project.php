<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FPC_Project extends Model
{
    protected $table = "IPC_DMS.FS_FPC_PROJECTS";
	protected $connection = "oracle";

	public function insert_fpc_project($params){
		$this->insert($params);
	}

	public function get_projects($fpc_id){
		$sql = "SELECT fpc_prj.fpc_project_id,
			            fc.customer_name,
			            dlr.account_name dealer_account,
			            dlr.customer_name dealer_name,
			            fp.project_id,
			            TO_CHAR(fp.creation_date,'MM/DD/YYYY') project_creation_date,
			            st.status_name project_status,
			            fpc_prj.fpc_id
				FROM ipc_dms.fs_fpc_projects fpc_prj
				    LEFT JOIN ipc_dms.fs_projects fp
				        ON fpc_prj.project_id = fp.project_id
				    LEFT JOIN ipc_dms.fs_customers fc
				        ON fc.customer_id = fp.customer_id
				    LEFT JOIN ipc_dms.fs_status st
				        ON st.status_id = fp.status
				    LEFT JOIN ipc_dms.dealers_v dlr
				        ON dlr.cust_account_id = fp.dealer_id
				 WHERE 1 = 1
				 	AND fpc_prj.fpc_id = :fpc_id";
		$params = [
			'fpc_id' => $fpc_id
		];

		$query = DB::select($sql,$params);
		return $query;
	}
}
