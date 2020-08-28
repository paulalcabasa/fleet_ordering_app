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
    protected $primaryKey = "fpc_id";
    
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
                        nvl(fpc.remarks,'-') remarks,
                        usr.email_address requestor_email
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
                        usr.email_address,
                        usr_prj.email_address requestor_email,
                        fpc_prj.project_id
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
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr_prj
                        ON usr_prj.user_id = fp.created_by
                        AND usr_prj.user_source_id = fp.create_user_Source_id
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

    public function getProjects($customer_id,$vehicle_type){
        $sql = "SELECT fs.project_id,
                        fs.customer_id,
                        fc.customer_name,
                        dlr.customer_name dealer_name,
                        dlr.account_name dealer_account,
                        st.status_name,
                        usr.first_name || ' ' || usr.last_name created_by,
                        to_char(fs.creation_date,'mm/dd/yyyy') date_created,
                        fs.dealer_id,
                        rh.vehicle_type,
                        rh.requirement_header_id,
                        null fpc_id
                FROM ipc_dms.fs_projects fs
                    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON fs.project_id = rh.project_id
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fs.customer_id = fc.customer_id 
                    LEFT JOIN ipc_dms.dealers_v dlr
                        ON dlr.cust_account_id = fs.dealer_id
                    LEFT JOIN ipc_dms.fs_status st
                        ON st.status_id = fs.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fs.created_by 
                        AND usr.user_source_id = fs.create_user_source_id
                WHERE 1 = 1
                        AND fs.status = 11
                        AND rh.status = 4
                        AND fs.customer_id = :customer_id
                        AND rh.vehicle_type = :vehicle_type
                        AND fs.project_id NOT IN (
                            SELECT project_id
                            FROM ipc_dms.fs_fpc_projects fpc_prj
                                LEFT JOIN ipc_dms.fs_fpc fpc
                                ON fpc.fpc_id = fpc_prj.fpc_id
                            WHERE 1 = 1
                                AND fpc.status IN(4,12)
                                AND fpc_prj.status NOT IN (6)
                                AND fpc.vehicle_type = :vehicle_type
                        )";
       
        $params = [
            'customer_id'  => $customer_id,
            'vehicle_type' => $vehicle_type
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function getConflictRequirements($project_ids,$vehicle_type){
        $sql = "SELECT sales_model,
                        color
                FROM (
                    SELECT vehicle.sales_model,
                                vehicle.color,
                                COUNT(vehicle.sales_model)  ctr
                    FROM ipc_dms.fs_prj_requirement_lines rl
                        LEFT JOIN ipc_dms.fs_prj_requirement_headers rh 
                            ON rl.requirement_header_id = rh.requirement_header_id
                        LEFT JOIN ipc_dms.ipc_vehicle_models_v vehicle
                            ON vehicle.inventory_item_id = rl.inventory_item_id
                    WHERE rh.project_id IN ($project_ids)
                        AND rh.vehicle_type = '".$vehicle_type."'
                    GROUP BY 
                                vehicle.sales_model,
                                vehicle.color
                ) 
                WHERE ctr > 1";
        $query = DB::select($sql);
        return $query;
    }

    public function getActiveFPC($customerId,$vehicleType){
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
                    AND fpc.vehicle_type = :vehicle_type
                    and fpc.customer_id = :customer_id
                    AND fpc.status = 12";
		$params = [
            "vehicle_type" => $vehicleType,
            "customer_id" => $customerId
		];
		$query = DB::select($sql,$params);
        return $query;
    }

    public function getActiveProjects($customer_id,$vehicle_type){
        $sql = "SELECT fs.project_id,
                        fs.customer_id,
                        fc.customer_name,
                        dlr.customer_name dealer_name,
                        dlr.account_name dealer_account,
                        st.status_name,
                        usr.first_name || ' ' || usr.last_name created_by,
                        to_char(fs.creation_date,'mm/dd/yyyy') date_created,
                        fs.dealer_id,
                        rh.vehicle_type,
                        rh.requirement_header_id,
                        fpc_prj.fpc_id
                FROM ipc_dms.fs_projects fs
                    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON fs.project_id = rh.project_id
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fs.customer_id = fc.customer_id 
                    LEFT JOIN ipc_dms.dealers_v dlr
                        ON dlr.cust_account_id = fs.dealer_id
                    LEFT JOIN ipc_dms.fs_status st
                        ON st.status_id = fs.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fs.created_by 
                        AND usr.user_source_id = fs.create_user_source_id
                    LEFT JOIN ipc_dms.fs_fpc_projects fpc_prj
                        ON fpc_prj.project_id = fs.project_id
                    LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_prj.fpc_id
                WHERE 1 = 1
                        AND fs.status = 11
                        AND rh.status = 4
                        AND fpc.status = 12
                        AND fs.customer_id = :customer_id
                        AND rh.vehicle_type = :vehicle_type
                        AND fs.project_id  IN (
                            SELECT project_id
                            FROM ipc_dms.fs_fpc_projects fpc_prj
                                LEFT JOIN ipc_dms.fs_fpc fpc
                                ON fpc.fpc_id = fpc_prj.fpc_id
                            WHERE 1 = 1
                                AND fpc.status IN(12)
                                AND fpc.vehicle_type = :vehicle_type
                        )";
       
        $params = [
            'customer_id'  => $customer_id,
            'vehicle_type' => $vehicle_type
        ];

        $query = DB::select($sql,$params);
        return $query;
    }


    public function get_approvers($fpc_id){
        $params = [
            'fpc_id' => $fpc_id
        ];
        $sql = "SELECT ma.approval_id,
                        fpc.fpc_id,
                        usr.first_name || ' '  || usr.last_name approver_name,
                        usr.email_address,
                        status.status_name,
                        to_char(ma.date_approved, 'MM/DD/YYYY HH:MI:SS') date_approved,
                        ma.hierarchy,
                        to_char(ma.date_sent, 'MM/DD/YYYY HH:MI:SS') date_sent,
                     
                        ma.remarks
                FROM ipc_dms.fs_fpc fpc
                    INNER JOIN ipc_dms.fs_module_approval ma
                        ON ma.module_reference_id = fpc.fpc_id
                    INNER JOIN ipc_dms.fs_approvers fa
                        ON fa.approver_id = ma.approver_id
                    INNER JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = fa.approver_user_id
                        AND fa.approver_source_id = usr.user_source_id
                    INNER JOIN ipc_dms.fs_status status
                        ON status.status_id = ma.status
                WHERE ma.module_id = 3
                    AND fpc.fpc_id = :fpc_id
                ORDER BY ma.hierarchy ASC";
        $query = DB::select($sql, $params);
        return $query;
    }

    public function get_pending(){
        $sql = "SELECT ma.approval_id,
                        fpc.fpc_id,
                        usr.first_name || ' '  || usr.last_name approver_name,
                        usr.email_address,
                        status.status_name,
                        ma.update_date,
                        fpc.customer_id,
                        cust.customer_name,
                        fpc.vehicle_type,
                        to_char(fpc.creation_date,'MM/DD/YYYY') date_created,
                         creator.first_name || ' '  || creator.last_name prepared_by
                FROM ipc_dms.fs_fpc fpc
                    INNER JOIN ipc_dms.fs_module_approval ma
                        ON ma.module_reference_id = fpc.fpc_id
                        AND ma.hierarchy = fpc.current_approval_hierarchy
                    INNER JOIN ipc_dms.fs_approvers fa
                        ON fa.approver_id = ma.approver_id
                    INNER JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = fa.approver_user_id
                        AND fa.approver_source_id = usr.user_source_id
                    INNER JOIN ipc_dms.fs_status status
                        ON status.status_id = ma.status
                    LEFT JOIN ipc_dms.fs_customers cust
                        ON cust.customer_id = fpc.customer_id
                    LEFT JOIN ipc_dms.ipc_portal_users_v creator
                          ON creator.user_id = fpc.created_by
                        AND creator.user_source_id = fpc.create_user_source_id
                WHERE ma.module_id = 3
                    AND fpc.status = 7 -- pending 
                    AND ma.date_sent IS NULL";
        $query = DB::select($sql);
        return $query;
    }



}
