<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class PriceListHeader extends Model
{
    protected $table = "IPC_DMS.FS_PRICELIST_HEADER";
	protected $connection = "oracle";
	const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

    public function insert_header($params){
    	$id = $this->insertGetId($params,'pricelist_header_id');
    	return $id;
    }

    public function get_details($pricelist_header_id){
        $sql = "SELECT fph.name,
                        nvl(fph.description,'-') description,
                        fst.status_name,
                        usr.first_name ||  ' ' || usr.last_name created_by,
                        fph.creation_date,
                        fph.pricelist_header_id
                FROM ipc_dms.fs_pricelist_header fph
                    LEFT JOIN ipc_dms.fs_status fst
                        ON fst.status_id = fph.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON USR.USER_ID = fph.created_by
                        AND USR.USER_SOURCE_ID = fph.create_user_source_id
                WHERE fph.pricelist_header_id = :pricelist_header_id";
        
        $params = [
            'pricelist_header_id' => $pricelist_header_id
        ];
        $query = DB::select($sql,$params);
        return $query[0];
    }

    public function get_headers(){
        $sql = "SELECT fph.name,
                        nvl(fph.description,'-') description,
                        fst.status_name,
                        usr.first_name ||  ' ' || usr.last_name created_by,
                        fph.creation_date,
                        fph.pricelist_header_id
                FROM ipc_dms.fs_pricelist_header fph
                    LEFT JOIN ipc_dms.fs_status fst
                        ON fst.status_id = fph.status
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON USR.USER_ID = fph.created_by
                        AND USR.USER_SOURCE_ID = fph.create_user_source_id";
        $query = DB::select($sql);
        return $query;
    }

}
