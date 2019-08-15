<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class ActivityLogs extends Model
{
	protected $table = "IPC_DMS.FS_ACTIVITY_LOGS";
    protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

    public function insert_log($params){
		$this->insert($params);
    }

    public function update_mail_flag($mail_flag,$project_id,$updated_by,$update_user_source){
        $this
            ->where([
                [ 'reference_id', '=' , $project_id ],
                [ 'reference_column', '=' , 'project_id' ],
            ])
            ->update([
                'mail_flag'             => $mail_flag,
                'updated_by'            => $updated_by,
                'update_user_source_id' => $update_user_source
            ]);
    }

    public function update_sent_flag($log_id, $date_sent){
        $this
            ->where([
                [ 'log_id', '=' , $log_id ]
            ])
            ->update([
                'is_sent_flag' => 'Y',
                'date_sent'    => $date_sent
            ]);
    }

    public function get_logs_for_mail(){
        $sql = "SELECT fl.log_id,
                        fl.module_id,
                        fl.module_code,
                        fl.content,
                        fl.reference_id,
                        fl.mail_recipient
                FROM ipc_dms.FS_ACTIVITY_LOGS fl 
                WHERE 1 = 1
                    AND fl.is_sent_flag = 'N'
                    AND fl.mail_flag = 'Y'";
        $query = DB::select($sql);
        return $query;
    }


}
