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

    	if($user_type == 31){ // dealer manager

            $approval_status = 7; // approval status pending
            $project_status = 3; // project status new

            $sql = "SELECT ma.approval_id,
                            ma.module_reference_id,
                            'Project' type,
                            fp.project_id,
                            fc.customer_name account_name,
                            to_char(ma.creation_date,'mm/dd/yyyy HH:MI:SS AM') date_submitted,
                            fs.status_name,
                            usr.first_name || ' ' || usr.last_name created_by,
                            ma.approver_id,
                            fa.approver_user_id,
                            fa.approver_source_id,
                            usr_app.first_name || ' ' || usr_app.last_name approver_name,
                            nvl(dlr_sat.account_name,hca.account_name) dealer_name
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
                    LEFT JOIN apps.hz_cust_accounts_all hca
                        ON hca.cust_account_id = fp.dealer_id
                    LEFT JOIN ipc_portal.dealers dlr_sat
                        ON dlr_sat.id = usr.dealer_satellite_id
                WHERE 1 = 1
                    AND fa.approver_user_id = :approver_id
                    AND fa.approver_source_id = :approver_source_id
                    AND fs.status_id = :approval_status      
                    AND fp.status = :project_status    
                    AND fp.dealer_id = :dealer_id";
            $params = [
                'project_status'     => $project_status,
                'approval_status'    => $approval_status,
                'approver_id'        => $approver_id,
                'approver_source_id' => $approver_source_id,
                'dealer_id'          => $dealer_id
            ];
            $query = DB::select($sql,$params);
            return $query;
    	}
    	else if($user_type == 32 || $user_type == 33){ // Fleet CV and LCV user	
            $approval_status = 7;
            $project_status = 7;
            $sql = "SELECT  ma.approval_id,
                            ma.module_reference_id,
                            'Project' type,
                            fp.project_id,
                            fc.customer_name account_name,
                            to_char(ma.creation_date,'mm/dd/yyyy HH:MI:SS AM') date_submitted,
                            fs.status_name,
                            usr.first_name || ' ' || usr.last_name created_by,
                            ma.approver_id,
                            fa.approver_user_id,
                            fa.approver_source_id,
                            usr_app.first_name || ' ' || usr_app.last_name approver_name,
                            rh.requirement_header_id,
                            hca.account_name dealer_name
                    FROM ipc_dms.fs_module_approval ma
                        INNER JOIN ipc_dms.fs_projects fp
                            ON ma.module_reference_id = fp.project_id
                        INNER JOIN ipc_dms.fs_prj_requirement_headers rh
                            ON rh.project_id = fp.project_id
                        INNER JOIN ipc_dms.fs_approvers fa
                            ON fa.approver_id = ma.approver_id
                            AND rh.vehicle_type = fa.vehicle_type
                        INNER JOIN ipc_dms.fs_status fs
                            ON fs.status_id = ma.status
                        LEFT JOIN ipc_dms.ipc_portal_users_v usr_app
                            ON usr_app.user_id = fa.approver_user_id
                            AND usr_app.user_source_id = fa.approver_source_id
                        LEFT JOIN ipc_dms.ipc_portal_users_v usr
                            ON usr.user_id = fp.created_by 
                            AND usr.user_source_id = fp.create_user_source_id
                        LEFT JOIN ipc_dms.fs_customers fc
                            ON fp.customer_id = fc.customer_id
                        LEFT JOIN apps.hz_cust_accounts_all hca
                            ON hca.cust_account_id = fp.dealer_id
                    WHERE 1 = 1
                        AND ma.column_reference = 'project_id'
                        AND ma.table_reference = 'fs_projects'
                        AND fa.approver_user_id = :approver_id
                        AND fa.approver_source_id = :approver_source_id
                        AND fs.status_id = :approval_status      
                        AND fp.status = :project_status";
            $params = [
                'project_status'     => $project_status,
                'approval_status'    => $approval_status,
                'approver_id'        => $approver_id,
                'approver_source_id' => $approver_source_id
            ];
            $query = DB::select($sql,$params);
            return $query;
    	}
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
            	'status'                => $status,
            	'remarks'               => $remarks,
            	'updated_by'            => $update_user,
            	'update_user_source_id' => $update_user_source
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

    public function get_per_project($project_id,$user_type, $vehicle_type) {
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
                    AND fa.user_type = :user_type
                    AND fa.vehicle_type = :vehicle_type";
        
        $params = [
            'project_id'  => $project_id,
            'vehicle_type'  => $vehicle_type,
       
            'user_type'   => $user_type
        ];
        $query = DB::select($sql,$params);
    
        return $query;
    }

    public function get_project_approval_workflow($project_id){
        $sql = "SELECT ma.approval_id,
                        fp.project_id,
                        fs.status_name,
                        ma.approver_id,
                        fa.approver_user_id,
                        fa.approver_source_id,
                        usr_app.first_name || ' ' || usr_app.last_name approver_name,
                        to_char(ma.update_date,'mm/dd/yyyy HH:MI:SS AM') date_approved,
                        ma.status,
                        fa.user_type,
                        fa.vehicle_type,
                        usr_app.email_address,
                        ma.remarks
                FROM ipc_dms.fs_module_approval ma
                    INNER JOIN ipc_dms.fs_projects fp
                        ON ma.module_reference_id = fp.project_id
                        AND ma.column_reference = 'project_id'
                        AND ma.table_reference = 'fs_projects'
                    INNER JOIN ipc_dms.fs_status fs
                        ON fs.status_id = ma.status
                    INNER JOIN ipc_dms.fs_approvers fa
                        ON fa.approver_id = ma.approver_id
                    INNER JOIN ipc_dms.ipc_portal_users_v usr_app
                        ON usr_app.user_id = fa.approver_user_id
                        AND usr_app.user_source_id = fa.approver_source_id  
                WHERE 1 = 1
                    AND ma.module_reference_id = :project_id
                ORDER BY ma.hierarchy";
        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function get_po_approval($approver_id,$approver_source_id){
        $sql = "SELECT ma.approval_id,
                        ma.module_reference_id,
                        'PO' type,
                        ph.project_id,
                        fc.customer_name account_name,
                        to_char(ma.creation_date,'mm/dd/yyyy HH:MI:SS AM') date_submitted,
                        fs.status_name,
                        usr.first_name || ' ' || usr.last_name created_by,
                        ma.approver_id,
                        fa.approver_user_id,
                        fa.approver_source_id,
                        usr_app.first_name || ' ' || usr_app.last_name approver_name,
                        nvl(dlr_sat.account_name,hca.account_name)   dealer_name
                FROM ipc_dms.fs_module_approval ma
                    INNER JOIN ipc_dms.fs_po_headers ph
                        ON ma.module_reference_id = ph.po_header_id
                        AND ma.column_reference = 'po_header_id'
                        AND ma.table_reference = 'fs_po_headers'
                    INNER JOIN ipc_dms.fs_projects fp   
                        ON fp.project_id = ph.project_id
                    INNER JOIN ipc_dms.fs_customers fc
                        ON fc.customer_id = fp.customer_id
                    INNER JOIN ipc_dms.fs_status fs
                        ON fs.status_id = ma.status
                    INNER JOIN ipc_dms.fs_approvers fa
                        ON fa.approver_id = ma.approver_id
                    INNER JOIN ipc_dms.ipc_portal_users_v usr_app
                        ON usr_app.user_id = fa.approver_user_id
                        AND usr_app.user_source_id = fa.approver_source_id  
                    INNER JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fp.created_by 
                        AND usr.user_source_id = fp.create_user_source_id
                    LEFT JOIN apps.hz_cust_accounts_all hca
                        ON hca.cust_account_id = fp.dealer_id 
                    LEFT JOIN ipc_portal.dealers dlr_sat
                        ON dlr_sat.id = usr.dealer_satellite_id
                WHERE 1 = 1
                    AND fa.approver_user_id = :approver_id
                    AND fa.approver_source_id = :approver_source_id
                    AND ma.status = :approval_status";
        
        $params = [
            'approver_id'        => $approver_id,
            'approver_source_id' => $approver_source_id,
            'approval_status'    => 7 // pending
        ];

        $query = DB::select($sql,$params);
    
        return $query;
    }

   public function get_pending_per_po($po_header_id){
        $sql = "SELECT count(ma.approval_id) ctr
                FROM ipc_dms.fs_module_approval ma   
                WHERE 1 = 1
                    AND ma.column_reference = :column_reference
                    AND ma.table_reference = :table_reference
                    AND ma.status = :status
                    AND ma.module_reference_id = :po_header_id";
        $params = [
            'column_reference' => 'po_header_id',
            'table_reference'  => 'fs_po_headers',
            'status'           => 7,
            'po_header_id'     => $po_header_id
        ];

        $query = DB::select($sql,$params);
    
        return $query[0]->ctr;
    }


    public function get_po_approval_workflow($po_header_id){
        $sql = "SELECT ma.approval_id,
                        poh.po_header_id,
                        fs.status_name,
                        ma.approver_id,
                        fa.approver_user_id,
                        fa.approver_source_id,
                        usr_app.first_name || ' ' || usr_app.last_name approver_name,
                        to_char(ma.update_date,'mm/dd/yyyy HH:MI:SS AM') date_approved,
                        ma.status,
                        fa.user_type,
                        fa.vehicle_type,
                        usr_app.email_address,
                        ma.remarks
                FROM ipc_dms.fs_module_approval ma
                    INNER JOIN ipc_dms.fs_po_headers poh
                        ON ma.module_reference_id = poh.po_header_id
                        AND ma.column_reference = 'po_header_id'
                        AND ma.table_reference = 'fs_po_headers'
                    INNER JOIN ipc_dms.fs_status fs
                        ON fs.status_id = ma.status
                    INNER JOIN ipc_dms.fs_approvers fa
                        ON fa.approver_id = ma.approver_id
                    INNER JOIN ipc_dms.ipc_portal_users_v usr_app
                        ON usr_app.user_id = fa.approver_user_id
                        AND usr_app.user_source_id = fa.approver_source_id  
                WHERE 1 = 1
                    AND ma.module_reference_id = :po_header_id
                ORDER BY ma.hierarchy";
        
        $params = [
            'po_header_id' => $po_header_id
        ];
        $query = DB::select($sql,$params);
    
        return $query;
    }

    public function delete_approval($approval_id){
        $this->where([
            [ 'approval_id', '=', $approval_id ]
        ])->delete();
    }


}
