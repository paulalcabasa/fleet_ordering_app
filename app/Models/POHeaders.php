<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class POHeaders extends Model
{
    protected $table = "IPC_DMS.FS_PO_HEADERS";
    protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    
    public function insert_po_header($params){
        $id = $this->insertGetId($params,'po_header_id');
        return $id;
    }

    public function get_all_po($dealer_id, $user_type){

        $where = "";

        if($user_type == 27 || $user_type == 30){ // Dealer staff or dealer manager
            $where = "AND fp.dealer_id = " . $dealer_id;
        }
        $sql = "SELECT ph.po_header_id,
                        ph.po_number,
                        ph.project_id,
                        fc.customer_name account_name,
                        to_char(ph.creation_date,'MM/DD/YYYY') date_created,
                        usr.first_name || ' ' || usr.last_name created_by,
                        fs.status_name
                FROM ipc_dms.fs_po_headers ph
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = ph.project_id
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fc.customer_id = fp.customer_id 
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = ph.created_by
                        AND ph.create_user_source_id = usr.user_source_id
                    LEFT JOIN ipc_dms.fs_status fs
                        ON fs.status_id = ph.status
                WHERE  1 = 1
                    {$where}";
        $query = DB::select($sql);
        return $query;
    }

    public function get_po_details($po_header_id){
        $sql = "SELECT ph.po_header_id,
                        ph.po_number,
                        ph.project_id,
                        fc.customer_name account_name,
                        to_char(ph.creation_date,'MM/DD/YYYY') date_created,
                        usr.first_name || ' ' || usr.last_name created_by,
                        fp.dealer_id,
                        fs.status_name
                FROM ipc_dms.fs_po_headers ph
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = ph.project_id
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fc.customer_id = fp.customer_id 
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = ph.created_by
                        AND ph.create_user_source_id = usr.user_source_id
                    LEFT JOIN ipc_dms.fs_status fs
                        ON fs.status_id = ph.status
                WHERE  1 = 1
                    AND ph.po_header_id = :po_header_id";
        $params = [
            'po_header_id' => $po_header_id
        ];

        $query = DB::select($sql, $params);

        return $query[0];
    }

    public function update_status($po_header_id,$status_id,$update_user,$update_user_source){
        $this
            ->where([
                [ 'po_header_id', '=' , $po_header_id ]
            ])
            ->update([
                'status'                => $status_id,
                'updated_by'            => $update_user,
                'update_user_source_id' => $update_user_source
            ]);
    }

    public function get_po_by_project($project_id){

        $sql = "SELECT ph.po_header_id,
                        ph.po_number,
                        ph.project_id,
                        fc.customer_name account_name,
                        to_char(ph.creation_date,'MM/DD/YYYY') date_created,
                        usr.first_name || ' ' || usr.last_name created_by,
                        fs.status_name
                FROM ipc_dms.fs_po_headers ph
                    LEFT JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = ph.project_id
                    LEFT JOIN ipc_dms.fs_customers fc
                        ON fc.customer_id = fp.customer_id 
                    LEFT JOIN ipc_dms.ipc_portal_users_v  usr
                        ON usr.user_id = ph.created_by
                        AND ph.create_user_source_id = usr.user_source_id
                    LEFT JOIN ipc_dms.fs_status fs
                        ON fs.status_id = ph.status
                WHERE  1 = 1
                    AND ph.project_id = :project_id";
        
        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql, $params);
        return $query;
    }

}