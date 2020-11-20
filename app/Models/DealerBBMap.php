<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DealerBBMap extends Model
{
    protected $connection = 'oracle';
    protected $table = 'ipc_dms.fs_body_builder_map';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getByDealerId($dealer_id){
        $sql = "SELECT dlr.id,
                        dlr.cust_account_id,
                        dlr.account_name,
                        body_builder.description body_builder,
                        aircon.description aircon
                FROM ipc_dms.fs_body_builder_map bb_map
                    LEFT JOIN ipc_portal.dealers dlr
                        ON dlr.id = bb_map.dealer_id
                    LEFT JOIN ipc_dms.fs_value_sets body_builder
                        ON body_builder.value_set_id = bb_map.body_builder_value_set_id
                    LEFT JOIN ipc_dms.fs_value_sets aircon
                        ON aircon.value_set_id = bb_map.aircon_value_set_id
                WHERE 1 = 1 
                    AND dlr.cust_account_id = :dealer_id";
        $query = DB::select($sql, ['dealer_id' => $dealer_id]);
        return $query;
    }
}
