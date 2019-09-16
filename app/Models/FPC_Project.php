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
                        fp.competitor_remarks,
                        usr.email_address requestor_email
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
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fp.created_by
                        AND usr.user_source_id = fp.create_user_source_id
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

    public function get_fpc_project_details($fpc_project_id){
        $sql = "SELECT fpc_prj.fpc_project_id,
                        fpc_prj.project_id,
                        dbb.abbreviation || 
                        to_char(fpc.creation_date,'MM') || 
                        to_char(fpc.creation_date,'YY') || 
                        '-' || 
                        fpc_prj.fpc_project_id fpc_ref_no,  
                        fc.customer_name,
                        dlr.customer_name dealer_name,
                        dlr.account_name dealer_account,
                        trim(to_char(fpc.creation_date,'Month')) || ' ' || trim(to_char(fpc.creation_date,'DD, YYYY'))  date_created,
                        fh.vehicle_type,
                        fh.requirement_header_id,
                        fpc_prj.note,
                        fpc_prj.availability,
                        trim(to_char(fpc_prj.validity,'Month')) || ' ' || trim(to_char(fpc_prj.validity,'DD, YYYY'))  validity,
                        terms.term_name,  
                        fcp.fleet_category_name,
                        usr.first_name || ' ' || usr.last_name prepared_by,
                        usr.position_title,
                        fpc.fpc_id       
                FROM ipc_dms.fs_fpc_projects fpc_prj
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = fpc_prj.project_id
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fc.customer_id = fp.customer_id
                    LEFT JOIN ipc_dms.dealers_v dlr
                        ON dlr.cust_account_id = fp.dealer_id
                    LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_prj.fpc_id
                    LEFT JOIN ipc_dms.fs_prj_requirement_headers fh
                        ON fh.requirement_header_id = fpc_prj.requirement_header_id 
                    LEFT JOIN ipc_dms.fs_payment_terms terms
                        ON terms.term_id = fpc_prj.payment_terms
                    LEFT JOIN ipc_dms.fs_fleet_categories fcp
                        ON fcp.fleet_category_id = fp.fleet_category
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = fpc.created_by
                        AND usr.user_source_id = fpc.create_user_source_id
                    LEFT JOIN ipc_dms.dealer_abbrev_names dbb
                        ON dbb.cust_account_id = fp.dealer_id
                WHERE 1 = 1
                    AND fpc_prj.fpc_project_id = :fpc_project_id";
        $params = [
            'fpc_project_id' => $fpc_project_id
        ];

        $query = DB::select($sql,$params);
        return $query[0];
    }

    public function get_projects_with_conflict($fpc_id,$item_ids){
        $query = DB::table('ipc_dms.fs_fpc_projects fpc_prj')
            ->leftJoin('ipc_dms.fs_fpc_items fpc_item',
                'fpc_item.fpc_project_id','=','fpc_prj.fpc_project_id')
            ->leftJoin('ipc_dms.fs_prj_requirement_lines rl',
                'rl.requirement_line_id', '=', 'fpc_item.requirement_line_id')
            ->where('fpc_prj.fpc_id','=', $fpc_id)
            ->whereIn('rl.inventory_item_id', $item_ids)
            ->selectRaw('DISTINCT 
                         fpc_prj.fpc_project_id,
                         fpc_prj.project_id')
            ->get();
        
        return $query;
    }

    public function update_fpc_status(
        $fpc_project_id, 
        $status,
        $user_id,
        $user_source_id
    ){
        $this
            ->where([
                [ 'fpc_project_id', '=' , $fpc_project_id ],
            ])
            ->update([
                'status'                => $status,
                'updated_by'            => $user_id,
                'update_user_source_id' => $user_source_id
            ]);
    }
}
