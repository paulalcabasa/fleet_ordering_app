<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FPC_Project extends Model
{
    protected $table = "IPC_DMS.FS_FPC_PROJECTS";
	protected $connection = "oracle";
	const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

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
			            fpc_prj.fpc_id,
			            fpc_prj.payment_terms,
			            to_char(fpc_prj.validity, 'YYYY-MM-DD') validity,
                        to_char(fpc_prj.validity, 'MM/DD/YYYY') validity_disp,
			            fpc_prj.availability,
			            fpc_prj.note,
                        pt.term_name,
                        fp.competitor_flag,
                        fp.competitor_remarks
				FROM ipc_dms.fs_fpc_projects fpc_prj
				    LEFT JOIN ipc_dms.fs_projects fp
				        ON fpc_prj.project_id = fp.project_id
				    LEFT JOIN ipc_dms.fs_customers fc
				        ON fc.customer_id = fp.customer_id
				    LEFT JOIN ipc_dms.fs_status st
				        ON st.status_id = fp.status
				    LEFT JOIN ipc_dms.dealers_v dlr
				        ON dlr.cust_account_id = fp.dealer_id
                    LEFT JOIN ipc_dms.fs_payment_terms pt 
                        ON pt.term_id = fpc_prj.payment_terms
				 WHERE 1 = 1
				 	AND fpc_prj.fpc_id = :fpc_id";
		$params = [
			'fpc_id' => $fpc_id
		];

		$query = DB::select($sql,$params);
		return $query;
	}

	public function update_fpc_project(
		$fpc_project_id, 
		$payment_terms,
		$validity,
		$availability,
		$note,
		$user_id,
		$user_source_id
	){
		$this
            ->where([
            	[ 'fpc_project_id', '=' , $fpc_project_id ],
            ])
            ->update([
            	'payment_terms'         => $payment_terms,
            	'validity'              => $validity,
            	'availability'          => $availability,
            	'note'                  => $note,
            	'updated_by'            => $user_id,
            	'update_user_source_id' => $user_source_id
            ]);
	}
}
