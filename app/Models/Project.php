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
            $where = "AND rh.vehicle_type = '" . $vehicle_type . "' AND fp.status IN (10,11)";
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
                            WHEN fp.status = 10 AND count(fpc.status) > 0 THEN 
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
                            WHEN fp.status = 10 AND count(ph.status) > 0 THEN 
                              CASE WHEN 
                                    SUM(
                                    CASE 
                                        WHEN ph.status = 11 THEN 1 ELSE 0
                                    END
                                     ) >= 1 THEN 'in_progress'
                                     ELSE 'good'
                                END
                            ELSE null
                        END  po_status,
                        CASE 
                            WHEN fp.status = 10 THEN 
                              CASE WHEN 
                                     COUNT(fwpc.fwpc_id) > 0 THEN 'good' ELSE 'in_progress'
                                
                                END
                            ELSE null
                       END  fwpc_status
                FROM ipc_dms.fs_projects fp
                    INNER JOIN ipc_dms.fs_customers fc
                        ON fp.customer_id = fc.customer_id 
                    INNER JOIN ipc_dms.dealers_v dlr
                        ON dlr.cust_account_id = fp.dealer_id
                    INNER JOIN ipc_dms.fs_status st
                        ON st.status_id = fp.status
                    INNER JOIN ipc_dms.ipc_portal_users_v usr
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
            	'status' => $status_id,
            	'updated_by' => $update_user,
            	'update_user_source_id' => $update_user_source
            ]);
    }

    public function get_details($project_id){
        $sql = "SELECT fs.project_id,
                        fs.customer_id,
                        fc.customer_name fleet_account_name,
                        dlr.customer_name dealer_name,
                        dlr.account_name dealer_account,
                        st.status_name,
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
                        usr.email_address requestor_email
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
                        AND st.status_name IN ('Acknowledged')
                        AND fs.customer_id = :customer_id
                        AND rh.vehicle_type = :vehicle_type";
       
        $params = [
            'customer_id'  => $customer_id,
            'vehicle_type' => $vehicle_type
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function count_all_projects($user_type,$dealer_id){
        if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $sql = "SELECT count(project_id) ctr
                    FROM ipc_dms.fs_projects
                    WHERE dealer_id = :dealer_id";
            $params = [
                'dealer_id' => $dealer_id
            ];
            $query = DB::select($sql,$params);
            return $query[0]->ctr;
        }
        else if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
            $sql = "SELECT count(project_id) ctr
                    FROM ipc_dms.fs_projects";
            $query = DB::select($sql);
            return $query[0]->ctr;            
        }
    }

    public function count_open_projects($user_type,$dealer_id){
        if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
           $sql = "SELECT count(project_id) ctr
                    FROM ipc_dms.fs_projects
                    WHERE dealer_id = :dealer_id
                        AND status <> 13";
            $params = [
                'dealer_id' => $dealer_id
            ];
            $query = DB::select($sql,$params);
            return $query[0]->ctr;
        }
        else if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
            
            
            $sql = "SELECT count(project_id) ctr
                    FROM ipc_dms.fs_projects
                    WHERE status <> 13";
            $query = DB::select($sql);
            return $query[0]->ctr;

        }
    }

    public function count_pending_fpc_projects($user_type,$dealer_id){
        if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $sql = "SELECT count(project_id) ctr
                    FROM ipc_dms.fs_projects
                    WHERE 1 = 1
                        AND dealer_id = :dealer_id
                        AND project_id NOT IN (
                            SELECT project_id 
                            FROM ipc_dms.fs_fpc_projects prj
                                LEFT JOIN ipc_dms.fs_fpc fpc
                                    ON FPC.FPC_ID = prj.fpc_id
                            WHERE fpc.status = 4
                        )";
            $params = [
                'dealer_id' => $dealer_id
            ];
            $query = DB::select($sql,$params);
            return $query[0]->ctr;
        }
        else if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
                $sql = "SELECT count(project_id) ctr
                        FROM ipc_dms.fs_projects
                        WHERE 1 = 1
                            AND project_id NOT IN (
                                SELECT project_id 
                                FROM ipc_dms.fs_fpc_projects prj
                                    LEFT JOIN ipc_dms.fs_fpc fpc
                                        ON FPC.FPC_ID = prj.fpc_id
                                WHERE fpc.status = 4
                            )";
                $query = DB::select($sql);
                return $query[0]->ctr;
        }

    }

    public function count_projects_yearly($user_type,$dealer_id,$year){
        if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $sql = "SELECT 
                    SUM(CASE WHEN extract(month from fp.creation_date) = 1 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) JAN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 2 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) FEB,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 3 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) MAR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 4 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) APR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 5 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) MAY,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 6 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) JUN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 7 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) JUL,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 8 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) AUG,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 9 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) SEP,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 10 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) OCT,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 11 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) NOV,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 12 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) DEC
                FROM ipc_dms.fs_projects fp
                WHERE fp.dealer_id = :dealer_id
                GROUP BY fp.creation_date";
            $params = [
                'dealer_id' => $dealer_id,
                'year' => $year
            ];
            $query = DB::select($sql,$params);
            return $query;
        }
        else if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
            $sql = "SELECT 
                    SUM(CASE WHEN extract(month from fp.creation_date) = 1 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) JAN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 2 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) FEB,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 3 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) MAR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 4 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) APR,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 5 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) MAY,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 6 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) JUN,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 7 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) JUL,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 8 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) AUG,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 9 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) SEP,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 10 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) OCT,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 11 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) NOV,
                    SUM(CASE WHEN extract(month from fp.creation_date) = 12 AND  extract(YEAR from fp.creation_date) = :year  THEN 1 ELSE 0 END) DEC
                FROM ipc_dms.fs_projects fp
                GROUP BY fp.creation_date";
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
                        AND    extract(YEAR from fp.creation_date) = $year 
                        AND extract(DAY from fp.creation_Date) = $i   THEN 1 ELSE 0 
                    END
                 ) day_" . $i;  
            }
            else {
                $select .= "SUM(
                    CASE 
                        WHEN extract(month from fp.creation_date) = $month 
                        AND    extract(YEAR from fp.creation_date) = $year
                        AND extract(DAY from fp.creation_Date) = $i   THEN 1 ELSE 0 
                    END
                 ) day_" . $i . ",";
            }
        }

        if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $sql = "SELECT 
                    $select
                    FROM ipc_dms.fs_projects fp
                    WHERE fp.dealer_id = ".$dealer_id."
                    GROUP BY fp.creation_date";
            $query = DB::select($sql);
            return $query[0];
        }
        else if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
            $sql = "SELECT 
                    $select
                    FROM ipc_dms.fs_projects fp
                    GROUP BY fp.creation_date";
            $query = DB::select($sql);
            return $query[0];
        }

    }
}
