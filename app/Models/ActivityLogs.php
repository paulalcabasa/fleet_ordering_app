<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
