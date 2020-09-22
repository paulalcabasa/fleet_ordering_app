<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class OutOffice extends Model
{
    //
    protected $table = "ipc_dms.fs_out_of_office";
    protected $fillable = ['approver_user_id'];
    public $timestamps = false;
    
    public function format()
    {
    
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ];
    
    }

    public function getAll(){
        $sql = "SELECT  out_office.id,
                        users.first_name || ' ' || users.last_name approver_name,
                        out_office.start_date,
                        out_office.end_date,
                        out_office.remarks,
                        out_office.approver_user_id,
                        out_office.approver_source_id
                FROM ipc_dms.fs_out_of_office out_office
                    LEFT JOIN ipc_dms.ipc_portal_users_v users
                        ON out_office.approver_user_id = users.user_id
                        AND out_office.approver_source_id = users.user_source_id"; 
        $query = DB::select($sql);
        return $query;     
    }

    public function getByUser($userId, $userSource){
        $sql = "SELECT  out_office.id,
                        users.first_name || ' ' || users.last_name approver_name,
                        out_office.start_date,
                        out_office.end_date,
                        out_office.remarks,
                        out_office.approver_user_id,
                        out_office.approver_source_id
                FROM ipc_dms.fs_out_of_office out_office
                    LEFT JOIN ipc_dms.ipc_portal_users_v users
                        ON out_office.approver_user_id = users.user_id
                        AND out_office.approver_source_id = users.user_source_id
                WHERE out_office.approver_user_id = :user_id
                    AND out_office.approver_source_id = :source_id";
          
        $params = [
            'user_id' => $userId,
            'source_id' => $userSource
        ];
        $query = DB::select($sql, $params);
        return $query;     
    }
}
