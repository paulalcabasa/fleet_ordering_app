<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Approver extends Model
{
    protected $table = "IPC_DMS.FS_APPROVERS";
    protected $connection = "oracle";
    protected $fillable = [
        'vehicle_type',
        'user_type',
        'requestor_user_id',
        'approver_user_id',
        'hierarchy',
        'status_id',
        'module_code',
        'approver_source_id',
        'requestor_source_id',
        'create_user_source_id',
        'created_by'
    ];
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    protected $primaryKey = 'approver_id';


    public function get_project_approvers($requestor_user_id,$user_type,$vehicle_type){
        //$params = [];
     /*   $sql = "SELECT fs_app.approver_id,
                            fs_app.vehicle_type,
                            fs_app.user_type,
                            fs_app.requestor_user_id,
                            fs_app.approver_user_id,
                            fs_app.hierarchy,
                            usr.first_name || ' ' || usr.last_name approver_name,
                            usr.email_address,
                            fs_app.module_code,
                            fs_app.approver_source_id
                    FROM ipc_dms.fs_approvers fs_app
                        LEFT JOIN ipc_dms.ipc_portal_users_v usr
                            ON usr.user_id = fs_app.approver_user_id
                            AND usr.user_source_id = fs_app.approver_source_id
                    WHERE 1 = 1";*/

    	if($user_type == "DLR_MANAGER"){
            $sql = "SELECT fs_app.approver_id,
                            fs_app.vehicle_type,
                            fs_app.user_type,
                            fs_app.requestor_user_id,
                            fs_app.approver_user_id,
                            fs_app.hierarchy,
                            usr.first_name || ' ' || usr.last_name approver_name,
                            usr.email_address,
                            fs_app.module_code,
                            fs_app.approver_source_id
                    FROM ipc_dms.fs_approvers fs_app
                        LEFT JOIN ipc_dms.ipc_portal_users_v usr
                            ON usr.user_id = fs_app.approver_user_id
                            AND usr.user_source_id = fs_app.approver_source_id
                    WHERE 1 = 1  
                        AND fs_app.requestor_user_id = :requestor_user_id
                        AND fs_app.user_type         = :user_type 
                        AND fs_app.status_id         = :status_id
                        AND fs_app.module_code       = :module_code";
            $params = [
                'requestor_user_id' => $requestor_user_id,
                'user_type'         => $user_type,
                'status_id'         => 1,
                'module_code'       => 'PRJ',
            ];
            $query = DB::select($sql,$params);
            return $query;

			/*$approvers = $this
				->select('approver_id','hierarchy')
				->where([
					['requestor_user_id', '=', $requestor_user_id],
					['user_type', '=', $user_type],
					['status_id', '=', 1],
                    ['module_code', '=', 'PRJ'] 
				])->get();*/
		}
		else if($user_type == "IPC_STAFF") {
            $sql = "SELECT fs_app.approver_id,
                            fs_app.vehicle_type,
                            fs_app.user_type,
                            fs_app.requestor_user_id,
                            fs_app.approver_user_id,
                            fs_app.hierarchy,
                            usr.first_name || ' ' || usr.last_name approver_name,
                            usr.email_address,
                            fs_app.module_code,
                            fs_app.approver_source_id
                    FROM ipc_dms.fs_approvers fs_app
                        LEFT JOIN ipc_dms.ipc_portal_users_v usr
                            ON usr.user_id = fs_app.approver_user_id
                            AND usr.user_source_id = fs_app.approver_source_id
                    WHERE 1 = 1
                        AND fs_app.vehicle_type = :vehicle_type
                        AND fs_app.user_type    = :user_type 
                        AND fs_app.status_id    = :status_id
                        AND fs_app.module_code  = :module_code";
            $params = [
                'vehicle_type' => $vehicle_type,
                'user_type'    => $user_type,
                'status_id'    => 1,
                'module_code'  => 'PRJ',
            ];
            $query = DB::select($sql,$params);
            return $query;
		/*	$approvers = $this
				->select('approver_id','hierarchy')
				->where([
					['user_type', '=', $user_type],
					['vehicle_type', '=', $vehicle_type],
					['status_id', '=', 1],
                    ['module_code', '=', 'PRJ']
				])->get();*/
		}


    }

    public function get_fpc_signatories($vehicle_type, $fpc_id){
        $sql = "SELECT usr.user_id,
                        usr.first_name,
                        usr.middle_name,
                        usr.last_name,
                        fa.user_type,
                        fa.vehicle_type,
                        fa.position_title,
                        usr.nickname,
                        usr.name_prefix,
                        fa.signatory_type,
                        fa.approver_id,
                        fa.hierarchy,
                        fa.e_signature_path,
                        approvers.status approval_status
                FROM ipc_dms.fs_approvers fa
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = fa.approver_user_id
                        AND fa.approver_source_id = usr.user_source_id
                    LEFT JOIN ipc_dms.fs_out_of_office out_office
                        ON out_office.approver_user_id = usr.user_id
                        AND out_office.approver_source_id = usr.user_source_id 
                        AND trunc(sysdate) >= out_office.start_date and trunc(sysdate) <= out_office.end_date
                    LEFT JOIN (
                        SELECT approval.approver_id,
                                approval.status,
                                approval.module_reference_id
                        FROM ipc_dms.fs_module_approval approval
                        WHERE 1 = 1 
                            AND approval.module_id = 3
                    ) approvers
                        ON approvers.approver_id = fa.approver_id
                        AND approvers.module_reference_id = :fpc_id
                WHERE 1 = 1
                    AND fa.user_type IN ('IPC_MANAGER','IPC_SUPERVISOR','IPC_EXPAT')
                    AND fa.vehicle_type = :vehicle_type
                    AND fa.status_id = 1
                    AND out_office.id IS NULL
                ORDER BY fa.hierarchy ASC";
        $params = [
            'vehicle_type' => $vehicle_type,
            'fpc_id' => $fpc_id
        ];
        /*
        SELECT usr.user_id,
                        usr.first_name,
                        usr.middle_name,
                        usr.last_name,
                        fa.user_type,
                        fa.vehicle_type,
                        fa.position_title,
                        usr.nickname,
                        usr.name_prefix,
                        fa.signatory_type,
                        fa.approver_id,
                        fa.hierarchy,
                        fa.e_signature_path,
                        approvers.status approval_status
                FROM ipc_dms.fs_approvers fa
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = fa.approver_user_id
                        AND fa.approver_source_id = usr.user_source_id
                    LEFT JOIN ipc_dms.fs_out_of_office out_office
                        ON out_office.approver_user_id = usr.user_id
                        AND out_office.approver_source_id = usr.user_source_id 
                        AND trunc(sysdate) >= out_office.start_date and trunc(sysdate) <= out_office.end_date
                    LEFT JOIN (
                        SELECT approver_id,
                                status
                        FROM ipc_dms.fs_module_approval approval
                        WHERE 1 =
                            AND approval.module_id = 3
                    ) approvers
                        ON approvers.approver_id = fa.approver_id 
                WHERE 1 = 1
                    AND fa.user_type IN ('IPC_MANAGER','IPC_SUPERVISOR','IPC_EXPAT')
                    AND fa.vehicle_type = :vehicle_type
                    AND fa.status_id = 1
                    AND out_office.id IS NULL
                ORDER BY fa.hierarchy ASC */
        $query = DB::select($sql,$params);
        return $query;
    }

    public function get_po_approvers($vehicle_type){
       $sql = "SELECT fs_app.approver_id,
                        fs_app.vehicle_type,
                        fs_app.user_type,
                        fs_app.requestor_user_id,
                        fs_app.approver_user_id,
                        fs_app.hierarchy,
                        usr.first_name || ' ' || usr.last_name approver_name,
                        usr.email_address,
                        fs_app.module_code,
                        fs_app.approver_source_id
                FROM ipc_dms.fs_approvers fs_app
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fs_app.approver_user_id
                        AND usr.user_source_id = fs_app.approver_source_id
                WHERE 1 = 1
                    AND fs_app.vehicle_type = :vehicle_type
                    AND fs_app.user_type    = :user_type 
                    AND fs_app.status_id    = :status_id
                    ";
                    // AND fs_app.module_code  = :module_code
        $params = [
            'vehicle_type' => $vehicle_type,
            'user_type'    => 'IPC_STAFF',
            'status_id'    => 1,
            //'module_code'  => 'PO',
        ];
        
        $query = DB::select($sql,$params);

 /*       $query = $this
            ->select('approver_id','hierarchy')
            ->where([
                ['user_type', '=', 'IPC_STAFF'],
                ['vehicle_type', '=', $vehicle_type],
                ['status_id', '=', 1],
                ['module_code', '=', 'PO']
            ])->get();*/
      
        return $query;
    }

    public function insert_approver($attrs,$values){
        Model::updateOrCreate($attrs,$values);
    }

    public function add_approver($params){
        $this->insert($params);
    }

    public function get_approvers(){
        $sql = "SELECT fs_app.approver_id,
                        usr.first_name || ' ' || usr.last_name approver_name,
                        fs_app.user_type,
                        fs_app.vehicle_type,
                        fs_app.requestor_user_id,
                        fs_app.approver_user_id,
                        fs_app.hierarchy,
                        fs_app.approver_source_id,
                        usr.email_address,
                        fs_app.module_code,
                        fs_app.status_id,
                        fs_app.signatory_type,
                        fs_app.position_title,
                        fs_app.hierarchy
                FROM ipc_dms.fs_approvers fs_app
                LEFT JOIN ipc_dms.ipc_portal_users_v usr
                    ON usr.user_id = fs_app.approver_user_id
                    AND usr.user_source_id = fs_app.approver_source_id
                WHERE 1 = 1
                ORDER BY fs_app.hierarchy ASC";
        $query = DB::select($sql);
        return $query;
    }

    public function update_status($params){
        $this
            ->where([
            	[ 'approver_id', '=' , $params['approver_id'] ],
            ])
            ->update([
            	'status_id'             => $params['status_id'],
            	'updated_by'            => $params['updated_by'],
            	'update_user_source_id' => $params['update_user_source_id']
            ]);
    }  
    
    public function update_approver($params){
        $this
            ->where([
            	[ 'approver_id', '=' , $params['approver_id'] ],
            ])
            ->update([
            	'hierarchy'             => $params['hierarchy'],
            	'vehicle_type'          => $params['vehicle_type'],
            	'user_type'             => $params['user_type'],
            	'signatory_type'        => $params['signatory_type'],
            	'position_title'        => $params['position'],
            	'approver_user_id'      => $params['approver_user_id'],
            	'approver_source_id'    => $params['approver_source_id'],
            	'updated_by'            => $params['updated_by'],
            	'update_user_source_id' => $params['update_user_source_id']
            ]);
    }  

    public function getApprovers(){
        $sql = "SELECT distinct users.user_id,
                        users.user_source_id,
                        users.first_name || ' ' || users.last_name approver_name
                FROM ipc_dms.fs_approvers approvers
                    LEFT JOIN ipc_dms.ipc_portal_users_v users
                        ON approvers.approver_user_id = users.user_id
                        AND approvers.approver_source_id = users.user_source_id
                WHERE approvers.signatory_type IN ('CHECKED_BY','NOTED_BY','EXPAT')";
        $query = DB::select($sql);
        return $query;
    }

    public function getDetails($approver_id){
        $sql = "SELECT  users.user_id,
                        users.user_source_id,
                        users.first_name || ' ' || users.last_name approver_name,
                        users.email_address
                FROM ipc_dms.fs_approvers approvers
                    LEFT JOIN ipc_dms.ipc_portal_users_v users
                        ON approvers.approver_user_id = users.user_id
                        AND approvers.approver_source_id = users.user_source_id
                WHERE approvers.approver_id = :approver_id";
        $query = DB::select($sql, ['approver_id' => $approver_id]);

        return $query[0];
    }

    public function getFPCApprovers($vehicle_type){
        $sql = "SELECT usr.user_id,
                        usr.first_name,
                        usr.middle_name,
                        usr.last_name,
                        fa.user_type,
                        fa.vehicle_type,
                        fa.position_title,
                        usr.nickname,
                        usr.name_prefix,
                        fa.signatory_type,
                        fa.approver_id,
                        fa.hierarchy,
                        fa.e_signature_path
                FROM ipc_dms.fs_approvers fa
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = fa.approver_user_id
                        AND fa.approver_source_id = usr.user_source_id
                    LEFT JOIN ipc_dms.fs_out_of_office out_office
                        ON out_office.approver_user_id = usr.user_id
                        AND out_office.approver_source_id = usr.user_source_id 
                        AND trunc(sysdate) >= out_office.start_date and trunc(sysdate) <= out_office.end_date
                WHERE 1 = 1
                    AND fa.user_type IN ('IPC_MANAGER','IPC_SUPERVISOR')
                    AND fa.vehicle_type = :vehicle_type
                    AND fa.status_id = 1
                    AND out_office.id IS NULL
                ORDER BY fa.hierarchy ASC";
        $params = [
            'vehicle_type' => $vehicle_type
        ];
   
        $query = DB::select($sql,$params);
        return $query;
    }

}
