<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FPCValidityRequest extends Model
{
    protected $table = "IPC_DMS.FS_FPC_VALIDITY_REQUEST AS vr";
	protected $connection = "oracle";
    const CREATED_AT = 'vr.CREATION_DATE';
    const UPDATED_AT = 'vr.UPDATE_DATE';

    public function insert_request($params){
        return $this->insertGetId($params,'request_id');
    }
    
    public function get_pending_request($fpc_project_id){
        $query = $this->selectRaw('vr.request_id,
                                   vr.fpc_project_id,
                                   vr.requestor_remarks,
                                   vr.original_validity_date,
                                   vr.requestor_remarks,
                                   vr.approver_remarks,
                                   vr.approved_date,
                                   vr.request_date,
                                   vr.status,
                                   prj.project_id
                                   ')
                        ->leftJoin('ipc_dms.fs_fpc_projects prj', 'prj.fpc_project_id', '=', 'vr.fpc_project_id')
                        ->where('vr.status', 7)
                        ->where('vr.fpc_project_id', $fpc_project_id)
                        ->get();
        return $query;
    }

    public function update_status($params){
        $this->where([
                [ 'vr.request_id', '=' , $params['request_id'] ]
            ])
            ->update([
                'vr.approved_date'         => $params['approved_date'],
                'vr.status'                => $params['status'],
                'vr.approver_remarks'      => $params['approver_remarks'],
                'vr.updated_by'            => $params['updated_by'],
                'vr.update_user_source_id' => $params['update_user_source_id']
            ]);
    }
}
