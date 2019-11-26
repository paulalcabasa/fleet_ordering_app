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
    protected $dates = [
        'creation_date',
        'UPDATE_DATE',
        // your other new column
    ];

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

    public function getRecentActivities($params){
      //  dd($params);
        return DB::table('ipc_dms.fs_activity_logs lg')
            ->leftJoin('ipc_dms.fs_projects fp', 'fp.project_id','=','lg.reference_id')
            ->selectRaw("lg.log_id,
                            lg.content,
                            to_char(lg.creation_date,'MM/DD/YYYY HH12:MI AM') creation_date,
                            fp.dealer_id")
            ->where($params)
            ->whereRaw('rownum <= 10')
            ->whereRaw("lg.timeline_flag = 'Y'")
            ->get();
    }

    public function get_recent_activities($user_type,$dealer_id){
        if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $sql = "SELECT lg.log_id,
                            lg.content,
                            to_char(lg.creation_date,'MM/DD/YYYY HH12:MI AM') creation_date,
                            fp.dealer_id
                    FROM ipc_dms.fs_activity_logs lg
                        LEFT JOIN ipc_dms.fs_projects fp
                            on fp.project_id = lg.reference_id
                    WHERE lg.timeline_flag = 'Y'
                        AND fp.dealer_id = :dealer_id
                        AND rownum <= 10
                    ORDER BY fp.creation_date DESC";
            $params = [
                'dealer_id' => $dealer_id
            ];

            $query = DB::select($sql,$params);
            return $query;
        }
        else if($user_type == 32 || $user_type == 33) { //  Fleet LCV User
            $sql = "SELECT lg.log_id,
                            lg.content,
                            to_char(lg.creation_date,'MM/DD/YYYY HH12:MI AM') creation_date,
                            fp.dealer_id
                    FROM ipc_dms.fs_activity_logs lg
                        LEFT JOIN ipc_dms.fs_projects fp
                            on fp.project_id = lg.reference_id
                    WHERE lg.timeline_flag = 'Y'
                        AND rownum <= 10
                    ORDER BY fp.creation_date DESC";
            $query = DB::select($sql);
            return $query;
        }
    }

    public function get_activities_by_project($project_id){
         $sql = "SELECT lg.log_id,
                        lg.content,
                        to_char(lg.creation_date,'MM/DD/YYYY HH12:MI AM') creation_date,
                        fp.dealer_id,
                        lg.creation_date raw_date
                FROM ipc_dms.fs_activity_logs lg
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = lg.reference_id
                WHERE lg.timeline_flag = 'Y'
                    AND fp.project_id = :project_id
                    ORDER BY lg.creation_date DESC";
            $params = [
                'project_id' => $project_id
            ];
            $query = DB::select($sql,$params);
            return $query;
    }



}
