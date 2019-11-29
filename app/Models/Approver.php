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

    public function get_fpc_signatories($vehicle_type){
        $sql = "SELECT usr.first_name,
                        usr.middle_name,
                        usr.last_name,
                        fa.user_type,
                        fa.vehicle_type,
                        usr.position_title,
                        usr.nickname,
                        usr.name_prefix
                FROM ipc_dms.fs_approvers fa
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = fa.approver_user_id
                        AND fa.approver_source_id = usr.user_source_id
                WHERE 1 = 1
                    AND fa.user_type IN ('IPC_MANAGER','IPC_SUPERVISOR','IPC_EXPAT')
                    AND fa.vehicle_type = :vehicle_type
                    AND fa.status_id = 1";
        $params = [
            'vehicle_type' => $vehicle_type
        ];

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
                        fs_app.position_title
                FROM ipc_dms.fs_approvers fs_app
                LEFT JOIN ipc_dms.ipc_portal_users_v usr
                    ON usr.user_id = fs_app.approver_user_id
                    AND usr.user_source_id = fs_app.approver_source_id
                WHERE 1 = 1";
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

}
