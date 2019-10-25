<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FPC extends Model
{
    protected $table = "IPC_DMS.FS_FPC";
	protected $connection = "oracle";
	const CREATED_AT = 'CREATION_DATE';
	const UPDATED_AT = 'UPDATE_DATE';
    
	public function insert_fpc($params){
    	return $this->insertGetId($params,'fpc_id');
    }

    public function get_fpc($vehicle_type){
    	$sql = "SELECT fpc.fpc_id,
                        fpc_prj.project_id,
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
                    LEFT JOIN ipc_dms.fs_fpc_projects fpc_prj
                        ON fpc_prj.fpc_id = fpc.fpc_id
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
			            fpc.customer_id,
                        nvl(fpc.remarks,'-') remarks
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


    public function update_status($fpc_id, $remarks, $user_id, $user_source_id, $status){
       $this
            ->where([
                [ 'fpc_id', '=' , $fpc_id ]
            ])
            ->update([
                'remarks'               => $remarks,
                'updated_by'            => $user_id,
                'update_user_source_id' => $user_source_id,
                'status'                => $status
            ]);
    }
    
    public function get_fpc_dealer($dealer_id){
        $sql = "SELECT 
                    fp.dealer_id,
                    fp.project_id,
                    dlr.customer_name dealer_name,
                    dlr.account_name,
                    fc.customer_name,
                    max(CASE WHEN rh.vehicle_type = 'LCV' THEN fpc_status.status_name ELSE NULL END) lcv_status,
                    max(CASE WHEN rh.vehicle_type = 'CV' THEN fpc_status.status_name ELSE NULL END) cv_status
                FROM ipc_dms.fs_fpc fpc
                        LEFT JOIN ipc_dms.fs_fpc_projects fpc_prj
                            ON fpc.fpc_id = fpc_prj.fpc_id
                        LEFT JOIN ipc_dms.fs_projects fp
                            ON fp.project_id = fpc_prj.project_id
                        LEFT JOIN ipc_dms.dealers_v dlr
                            ON dlr.cust_account_id = fp.dealer_id      
                        LEFT JOIN ipc_dms.fs_customers fc
                            ON fc.customer_id = fp.customer_id
                        LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                            ON rh.requirement_header_id = fpc_prj.requirement_header_id
                        LEFT JOIN ipc_dms.fs_status fpc_status
                            ON fpc_status.status_id = fpc.status
                WHERE 1 = 1
                        AND fp.dealer_id = :dealer_id
                GROUP BY fp.dealer_id,
                            fp.project_id,
                            dlr.customer_name,
                            dlr.account_name,
                            fc.customer_name";

        $params = [
            'dealer_id' => $dealer_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function get_fpc_by_project($project_id){
        $sql = "SELECT  fpc_prj.fpc_id,
                        fpc_prj.fpc_project_id,
                        st.status_name,
                        rh.vehicle_type,
                        fpc.remarks,
                        trim(to_char(fpc.creation_date,'Month')) || ' ' || trim(to_char(fpc.creation_date,' DD, YYYY')) date_created,
                        usr.first_name || ' ' || usr.last_name prepared_by,
                        pt.term_name,
                        fpc_prj.validity validity_date,
                        trim(to_char(fpc_prj.validity,'Month')) || ' ' || trim(to_char(fpc_prj.validity,' DD, YYYY')) validity,
                        fpc_prj.availability,
                        fpc_prj.note,
                        flt_c.fleet_category_name,
                        usr.email_address
                FROM ipc_dms.fs_fpc_projects fpc_prj
                    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON rh.requirement_header_id = fpc_prj.requirement_header_id
                    LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_prj.fpc_id
                    LEFT JOIN ipc_dms.fs_status st
                        ON st.status_id = fpc.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fpc.created_by
                        AND usr.user_source_id = fpc.create_user_Source_id
                    LEFT JOIN ipc_dms.fs_payment_terms pt
                        ON pt.term_id = fpc_prj.payment_terms
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = fpc_prj.project_id
                    LEFT JOIN ipc_dms.fs_fleet_categories flt_c
                        ON flt_c.fleet_category_id = fp.fleet_category
                WHERE 1 = 1
                    AND fpc_prj.project_id = :project_id
                    AND fpc.status = 4";

        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);

        return $query;
    }

    public function get_fpc_by_id($fpc_id){
        $sql = "SELECT  fpc_prj.fpc_id,
                        fpc_prj.fpc_project_id,
                        st.status_name,
                        rh.vehicle_type,
                        fpc.remarks,
                        trim(to_char(fpc.creation_date,'Month')) || ' ' || trim(to_char(fpc.creation_date,' DD, YYYY')) date_created,
                        usr.first_name || ' ' || usr.last_name prepared_by,
                        pt.term_name,
                        fpc_prj.validity,
                        trim(to_char(fpc_prj.validity,'Month')) || ' ' || trim(to_char(fpc_prj.validity,' DD, YYYY')) validity,
                        fpc_prj.availability,
                        fpc_prj.note,
                        flt_c.fleet_category_name
                FROM ipc_dms.fs_fpc_projects fpc_prj
                    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON rh.requirement_header_id = fpc_prj.requirement_header_id
                    LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_prj.fpc_id
                    LEFT JOIN ipc_dms.fs_status st
                        ON st.status_id = fpc.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fpc.created_by
                        AND usr.user_source_id = fpc.create_user_Source_id
                    LEFT JOIN ipc_dms.fs_payment_terms pt
                        ON pt.term_id = fpc_prj.payment_terms
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = fpc_prj.project_id
                    LEFT JOIN ipc_dms.fs_fleet_categories flt_c
                        ON flt_c.fleet_category_id = fp.fleet_category
                WHERE 1 = 1
                    AND  fpc_prj.fpc_id = :fpc_id";

        $params = [
            'fpc_id' => $fpc_id
        ];

        $query = DB::select($sql,$params);

        return $query;
    }

    public function get_max_validity_by_project($project_id){
        $sql = "SELECT nvl(max(fpc_prj.validity),sysdate) max_validity
                FROM ipc_dms.fs_fpc_projects fpc_prj
                    INNER JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_prj.fpc_id
                WHERE 1 = 1
                AND  fpc_prj.project_id = :project_id
                AND fpc.status = 4";
        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);

        return !empty($query) ? $query[0]->max_validity : null;

    }

    public function get_filtered_fpc(
        $user_type,
        $dealer_id,
        $start_date,
        $end_date,
        $customer_id,
        $status,
        $vehicle_type
    ){

        $where = "";
        
        
        if($user_type == 32 || $user_type == 33){ // Dealer staff or dealer manager
            $where = "AND fpc.vehicle_type = '".$vehicle_type."'";
        }
        

        if($start_date != "" && $end_date != ""){
            $where .= " AND trunc(fpc.creation_date) BETWEEN '".$start_date."' AND '". $end_date."'";
        }
        if($dealer_id != ""){
            $where .= "AND fp.dealer_id = " . $dealer_id;
        }
        if($customer_id != ""){
            $where .= "AND fp.customer_id = " . $customer_id;
        }

        if($status != ""){
            $where .= "AND fpc.status = " . $status;
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
                    LEFT JOIN ipc_dms.fs_fpc_projects fpc_prj
                        ON fpc_prj.fpc_id = fpc.fpc_id
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = fpc_prj.project_id
                WHERE 1 = 1
                {$where}
                GROUP BY fpc.fpc_id,
                        fc.customer_name,
                        fpc.vehicle_type,
                        fs.status_name,
                        usr.first_name, 
                        usr.last_name,
                        fpc.creation_date";
      
        $query = DB::select($sql);
        return $query;
    }





}
