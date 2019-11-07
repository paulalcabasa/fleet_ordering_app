<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Reports extends Model
{
    public function get_inquiry_history($params){
   
        $sql = "SELECT fp.project_id,
                        fc.customer_name,
                        dlr.account_name,
                        to_char(fp.creation_date,'MM/DD/YYYY') date_created
                FROM ipc_dms.fs_projects fp
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fc.customer_id = fp.customer_id
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fp.created_by
                        AND usr.user_source_id = fp.create_user_source_id
                    LEFT JOIN   ipc_dms.dealers_v dlr
                        ON dlr.cust_account_id = fp.dealer_id
                WHERE 1 = 1
                    AND trunc(fp.creation_date) BETWEEN '".$params['start_date']."' AND '". $params['end_date']."'";
        $query = DB::select($sql);
        return $query;

    }
}
