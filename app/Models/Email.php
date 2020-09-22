<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Email extends Model
{
   

    public function getMailCredentials(){
        $sql = "SELECT nse.id,
                            ne.email,
                            ne.email_password,
                            st.system
                FROM ipc_central.notification_system_email nse
                    LEFT JOIN ipc_central.system_tab st 
                        ON nse.system_id = st.id
                    LEFT JOIN ipc_central.notification_emails ne
                        ON ne.id = nse.notif_email_id
                WHERE st.system = 'Fleet Ordering System'";
        $query = DB::connection('ipc_central')->select($sql);
        return !empty($query)  ? $query[0] : $query;
    }

    
    
  
}
