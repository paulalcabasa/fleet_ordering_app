<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FPCValidityRequest extends Model
{
    protected $table = "IPC_DMS.FS_FPC_VALIDITY_REQUEST";
	protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

    public function insert_request($params){
        return $this->insertGetId($params,'request_id');
    }
    
    public function get_pending_request($fpc_project_id){
        $query = $this->where('status', 7)
                        ->where('fpc_project_id', $fpc_project_id)
                        ->get();
        return $query;
    }
}
