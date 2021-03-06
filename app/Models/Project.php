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
    	$where = "";
        $addtl_table = "";
    	if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $where = "AND fp.dealer_id = " . $dealer_id;
    	}
    	else if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
            if($user_type == 32) {
                $vehicle_type  = 'LCV';
            }
            else if($user_type == 33){
                $vehicle_type = 'CV';
            }
            $where = "AND rh.vehicle_type = '" . $vehicle_type . "'";//  AND fp.status IN (10,11,13)
            $addtl_table = "LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                                ON rh.project_id = fp.project_id";
    	}

        $sql = "SELECT  fp.project_id,
                        fp.customer_id,
                        fc.customer_name,
                        dlr.account_name,
                        st.status_name,
                        fp.status,
                        usr.first_name || ' ' || usr.last_name created_by,
                        to_char(fp.creation_date,'mm/dd/yyyy') date_created,
                        fp.dealer_id,
                        CASE 
                            WHEN fp.status IN(11,13) AND count(fpc.status) > 0 THEN 
                                CASE WHEN 
                                    SUM(
                                        CASE 
                                            WHEN fpc.status = 12 THEN 1 ELSE 0
                                        END
                                    ) >= 1 THEN 'in_progess'
                                    ELSE 'good'
                                END
                            ELSE null
                        END fpc_status,
                        CASE 
                            WHEN fp.status IN(11,13) AND count(ph.status) > 0 THEN 
                              CASE WHEN 
                                    SUM(
                                    CASE 
                                        WHEN ph.status = 7 THEN 1 ELSE 0
                                    END
                                     ) >= 1 THEN 'in_progress'
                                     ELSE 'good'
                                END
                            ELSE null
                        END  po_status,
                        CASE 
                            WHEN fp.status IN(11,13) THEN 
                                CASE WHEN
                                    SUM(
                                        CASE WHEN fwpc.status = 4 THEN 1 
                                        ELSE 0 
                                    END) > 0
                                    THEN 'good' 
                                    ELSE 'in_progress'
                                END
                            ELSE null
                       END  fwpc_status
                FROM ipc_dms.fs_projects fp
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fp.customer_id = fc.customer_id 
                    LEFT JOIN ipc_dms.dealers_v dlr
                        ON dlr.cust_account_id = fp.dealer_id
                    LEFT JOIN ipc_dms.fs_status st
                        ON st.status_id = fp.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fp.created_by 
                        AND usr.user_source_id = fp.create_user_source_id
                    {$addtl_table}
                    LEFT JOIN ipc_dms.fs_fpc_projects fpc_prj
                        ON fpc_prj.project_id = fp.project_id
                    LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_prj.fpc_id
                    LEFT JOIN ipc_dms.fs_po_headers ph
                        ON ph.project_id = fp.project_id
                    LEFT JOIN ipc_dms.fs_fwpc fwpc
                        ON fwpc.project_id = fp.project_id    
                WHERE 1 = 1
                    {$where}
                GROUP BY fp.project_id,
                        fp.customer_id,
                        fc.customer_name,
                        dlr.account_name,
                        st.status_name,
                        usr.first_name,
                        usr.last_name,
                        fp.creation_date,
                        fp.dealer_id,
                        fp.status";
        $query = DB::select($sql);

        return $query;

    }

    public function update_status($project_id,$status_id,$update_user,$update_user_source){
    	$this
            ->where([
            	[ 'project_id', '=' , $project_id ]
            ])
            ->update([
            	'status'                => $status_id,
            	'updated_by'            => $update_user,
            	'update_user_source_id' => $update_user_source
            ]);
    }

    public function get_details($project_id){
        /*,
        fc.organization_type_id,
        fc.tin,
        fc.address,
        fc.business_style,
        fc.establishment_date,
        fc.products,
        fc.company_overview
        */
        $sql = "SELECT fs.project_id,
                        fs.customer_id,
                        fc.customer_name fleet_account_name,
                        dlr.customer_name dealer_name,
                        dlr.account_name dealer_account,
                        st.status_name,
                        st.status_id,
                        usr.first_name || ' ' || usr.last_name created_by,
                        to_char(fs.creation_date,'mm/dd/yyyy') date_created,
                        fs.dealer_id,
                        fps.source_name project_source,
                        fs.email,
                        fs.facebook_url,
                        fs.website_url,
                        fs.bid_ref_no,
                        fs.bid_docs_amount,
                        to_char(fs.pre_bid_sched,'mm/dd/yyyy') pre_bid_sched,
                        to_char(fs.bid_date_sched,'mm/dd/yyyy') bid_date_sched,
                        fs.bidding_venue,
                        fs.approved_budget_cost,
                        fs.competitor_remarks,
                        fs.competitor_flag,
                        ffc.fleet_category_name,
                        fs.dealer_id,
                        usr.email_address requestor_email,
                        fs.project_source_id,
                        fs.fleet_category,
                        fc.address,
                        fc.tin,
                        fc.business_style,
                        cust.party_name oracle_customer,
                        fc.organization_type_id
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
                    LEFT JOIN ipc_dms.fs_project_sources fps
                        ON fps.project_source_id = fs.project_source_id
                    LEFT JOIN ipc_dms.fs_fleet_categories ffc
                        ON ffc.fleet_category_id = fs.fleet_category
                    LEFT JOIN ipc_dms.oracle_customers_v cust
                        ON cust.cust_account_id = fs.oracle_customer_id
                        AND cust.profile_class = 'Dealers-Fleet'
                WHERE 1 = 1
                    AND fs.project_id = :project_id";

        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);
        return !empty($query) ? $query[0] : $query;
    }

    public function get_projects_for_fpc($customer_id,$vehicle_type){
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
                        rh.requirement_header_id
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
                                AND fpc.vehicle_type = :vehicle_type
                        )";
       
        $params = [
            'customer_id'  => $customer_id,
            'vehicle_type' => $vehicle_type
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function count_projects_yearly($user_type,$dealer_id,$year){
        if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $sql = "SELECT 
                    SUM(CASE WHEN extract(month from fp.creation_date) = 1 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.value(1,100)) JAN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 2 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  FEB,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 3 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  MAR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 4 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  APR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 5 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  MAY,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 6 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  JUN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 7 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.value(1,100))   JUL,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 8 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  AUG,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 9 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  SEP,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 10 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  OCT,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 11 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  NOV,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 12 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  DEC
                FROM ipc_dms.fs_projects fp
                WHERE fp.dealer_id = :dealer_id";
            $params = [
                'dealer_id' => $dealer_id,
                'year' => $year
            ];
            $query = DB::select($sql,$params);
            return $query;
        }
        else if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
            $sql = "SELECT 
                    SUM(CASE WHEN extract(month from fp.creation_date) = 1 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100))  JAN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 2 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) FEB,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 3 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) MAR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 4 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) APR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 5 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) MAY,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 6 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) JUN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 7 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) JUL,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 8 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) AUG,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 9 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) SEP,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 10 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) OCT,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 11 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) NOV,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 12 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.VALUE(1,100)) DEC
                FROM ipc_dms.fs_projects fp";
            $params = [
                'year' => $year
            ];
            $query = DB::select($sql,$params);
            return $query;
        }
    }

    public function count_projects_monthly($last_day,$month, $year, $user_type, $dealer_id){
        $select = "";
        for($i = 1; $i <= $last_day; $i++){
            if($i == $last_day){
                $select .= "SUM(
                    CASE 
                        WHEN extract(month from fp.creation_date) = $month 
                        AND extract(YEAR from fp.creation_date) = $year 
                        AND extract(DAY from fp.creation_date) = $i   THEN 1 ELSE 0 
                    END
                 ) day_" . $i;  
            }
            else {
                $select .= "SUM(
                    CASE 
                        WHEN extract(month from fp.creation_date) = $month 
                        AND    extract(YEAR from fp.creation_date) = $year
                        AND extract(DAY from fp.creation_date) = $i   THEN 1 ELSE 0 
                    END
                 ) day_" . $i . ",";
            }
        }

        if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $sql = "SELECT 
                    $select
                    FROM ipc_dms.fs_projects fp
                    WHERE fp.dealer_id = ".$dealer_id."
                    ";
            $query = DB::select($sql);
            return $query[0];
        }
        else if(in_array($user_type,array(32,33,25,30)) ) { //  Fleet LCV User
            $sql = "SELECT 
                    $select
                    FROM ipc_dms.fs_projects fp
                    ";
            $query = DB::select($sql);
            return $query[0];
        }
       
    }

    public function get_filtered_projects(
        $user_type,
        $dealer_id,
        $start_date,
        $end_date,
        $customer_id,
        $status,
        $user_id,
        $user_source_id,
        $dealer_satellite_id
    ){
        $where = "";
        $addtl_table = "";
     
        if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
            if($user_type == 32) {
                $vehicle_type  = 'LCV';
            }
            else if($user_type == 33){
                $vehicle_type = 'CV';
            }
            $where = "AND rh.vehicle_type = '" . $vehicle_type . "'";//  AND fp.status IN (10,11,13)
            $addtl_table = "LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                                ON rh.project_id = fp.project_id";
        }

        if($start_date != "" && $end_date != ""){
            $where .= " AND trunc(fp.creation_date) BETWEEN '".$start_date."' AND '". $end_date."'";
        }

        if($dealer_id != ""){
            $where .= "AND fp.dealer_id = " . $dealer_id;
        }

        if($user_type == 27 || $user_type == 31){
            if($dealer_satellite_id != ""){
                $where .= "AND usr.dealer_satellite_id = " . $dealer_satellite_id;
            }
            else {
                $where .= "AND usr.dealer_satellite_id IS NULL ";
            }
        }

        if($customer_id != ""){
            $where .= "AND fp.customer_id = " . $customer_id;
        }

        if($status != ""){
            $where .= "AND fp.status = " . $status;
        }

        if($user_type == 27) { // dealer staff
            $where .= "AND fp.created_by = " . $user_id . " AND fp.create_user_source_id = " . $user_source_id;
        }

       // DB::enableQueryLog();

        $sql = "SELECT  fp.project_id,
                        fp.customer_id,
                        fc.customer_name,
                        nvl(dlr_sat.account_name,usr.account_name) account_name,
                        st.status_name,
                        fp.status,
                        usr.first_name || ' ' || usr.last_name created_by,
                        to_char(fp.creation_date,'mm/dd/yyyy') date_created,
                        fp.dealer_id,
                        CASE 
                            WHEN fp.status IN(11,13) AND count(CASE WHEN fpc.status = 4 THEN 1 ELSE NULL END) > 0 THEN 
                            CASE WHEN 
                                    SUM(
                                        CASE 
                                            WHEN fpc.status = 12 THEN 1 ELSE 0
                                        END
                                    ) >= 1 THEN 'in_progess'
                                    ELSE 'good'
                                END
                            ELSE null
                        END fpc_status,
                        CASE 
                            WHEN fp.status IN(11,13) AND count(ph.status) > 0 THEN 
                              CASE WHEN 
                                    SUM(
                                    CASE 
                                        WHEN ph.status = 7 THEN 1 ELSE 0
                                    END
                                     ) >= 1 THEN 'in_progress'
                                     ELSE 'good'
                                END
                            ELSE null
                        END  po_status,
                        CASE 
                            WHEN fp.status IN(11,13) THEN 
                                CASE WHEN
                                    SUM(
                                        CASE WHEN fwpc.status = 4 THEN 1 
                                        ELSE 0 
                                    END) > 0
                                    THEN 'good' 
                                    ELSE 'in_progress'
                                END
                            ELSE null
                       END  fwpc_status
                FROM ipc_dms.fs_projects fp
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fp.customer_id = fc.customer_id 
               
                    LEFT JOIN ipc_dms.fs_status st
                        ON st.status_id = fp.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fp.created_by 
                        AND usr.user_source_id = fp.create_user_source_id
                    {$addtl_table}
                    LEFT JOIN ipc_dms.fs_fpc_projects fpc_prj
                        ON fpc_prj.project_id = fp.project_id
                    LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_prj.fpc_id
                    LEFT JOIN ipc_dms.fs_po_headers ph
                        ON ph.project_id = fp.project_id
                    LEFT JOIN ipc_dms.fs_fwpc fwpc
                        ON fwpc.project_id = fp.project_id    
                    LEFT JOIN ipc_portal.dealers dlr_sat
                        ON dlr_sat.id = usr.dealer_satellite_id
                WHERE 1 = 1
                   {$where}
                GROUP BY fp.project_id,
                        fp.customer_id,
                        fc.customer_name,
                        st.status_name,
                        usr.first_name,
                        usr.last_name,
                        fp.creation_date,
                        fp.dealer_id,
                        fp.status,
                        usr.account_name,dlr_sat.account_name";
        $query = DB::select($sql);
        
     //   $query = DB::getQueryLog();

//$query = end($query);

//print_r($query);

        return $query;
    }

    public function update_project($params){
        $this
            ->where([
                [ 'project_id', '=' , $params['project_id'] ]
            ])
            ->update([
                'customer_id'           => $params['customer_id'],
                'project_source_id'     => $params['project_source_id'],
                'status'                => $params['status'],
                'email'                 => $params['email'],
                'facebook_url'          => $params['facebook_url'],
                'website_url'           => $params['website_url'],
                'bid_ref_no'            => $params['bid_ref_no'],
                'bid_docs_amount'       => $params['bid_docs_amount'],
                'pre_bid_sched'         => $params['pre_bid_sched'],
                'bid_date_sched'        => $params['bid_date_sched'],
                'approved_budget_cost'  => $params['approved_budget_cost'],
                'fleet_category'        => $params['fleet_category'],
                'bidding_venue'         => $params['bidding_venue'],
                'competitor_flag'       => $params['competitor_flag'],
                'competitor_remarks'    => $params['competitor_remarks'],
                'updated_by'            => $params['updated_by'],
                'update_user_source_id' => $params['update_user_source_id']
            ]);
    }

    public function countProjects($params, $statusIn = []){        
        return DB::table('ipc_dms.fs_projects fp')
            ->leftJoin('ipc_dms.fs_prj_requirement_headers rh', 'rh.project_id', '=', 'fp.project_id')
            ->when($params, function ($query, $params) {  
                return $query->where($params);
            })
            ->when($statusIn, function ($query, $statusIn) {
                return $query->whereIn('fp.status', $statusIn);
            })
            ->distinct('fp.project_id')
            ->count('fp.project_id');
    }

    public function countAllProjects(){        
        return DB::table('ipc_dms.fs_projects fp')
        //    ->leftJoin('ipc_dms.fs_prj_requirement_headers rh', 'rh.project_id', '=', 'fp.project_id')
           // ->distinct('fp.project_id')
            ->whereNotIn('status',[6,5])
            ->count('fp.project_id');
    }

 

    public function countPendingFPC($params = []){ 
        return DB::table('ipc_dms.fs_projects fp')
            ->leftJoin('ipc_dms.fs_prj_requirement_headers rh', 'rh.project_id', '=', 'fp.project_id')
            ->when($params, function ($query, $params) {  
                return $query->where($params);
            })
            ->whereNotIn('fp.project_id', function($query){
                $query->select(DB::raw('prj.project_id'))
                    ->from('ipc_dms.fs_fpc_projects prj')
                    ->leftJoin('ipc_dms.fs_fpc fpc','prj.fpc_id', '=', 'fpc.fpc_id')
                    ->whereRaw('fpc.status = 4');
            })
            ->distinct('fp.project_id')
            ->count('fp.project_id');
    }

    public function countProjectsYearly($params,$whereRaw){
        return DB::table('ipc_dms.fs_projects fp')
            ->leftJoin('ipc_dms.fs_prj_requirement_headers rh', 'rh.project_id', '=', 'fp.project_id')
            ->selectRaw("SUM(CASE WHEN extract(month from fp.creation_date) = 1  THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.value(1,100)) JAN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 2   THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  FEB,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 3   THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  MAR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 4   THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  APR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 5   THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  MAY,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 6   THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  JUN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 7    THEN 1 ELSE 0 END) + TRUNC(DBMS_RANDOM.value(1,100))   JUL,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 8    THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  AUG,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 9   THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  SEP,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 10   THEN 1 ELSE 0 END)  + TRUNC(DBMS_RANDOM.value(1,100))  OCT,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 11   THEN 1 ELSE 0 END)   NOV,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 12   THEN 1 ELSE 0 END)   DEC")
            ->when($params, function($query, $params) {
                return $query->where($params);
            })
            ->whereRaw($whereRaw)
            ->distinct('fp.project_id')
            ->count('fp.project_id');
    }

    public function updateOracleCustomer($params){
        $this
            ->where([
            	[ 'project_id', '=' , $params['project_id'] ]
            ])
            ->update([
            	'oracle_customer_id'    => $params['customer_id'],
            	'updated_by'            => $params['update_user'],
            	'update_user_source_id' => $params['update_user_source']
            ]);
    }
    

}
