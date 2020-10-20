<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PriceListLine extends Model
{
    protected $table = "IPC_DMS.FS_PRICELIST_LINES";
	protected $connection = "oracle";
	const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

    public function insert_line($params){
        $this->insert($params);
    }

    
	public function get_lines($pricelist_header_id){
        $sql = "SELECT vehicle.sales_model,
                        vehicle.color,
                        fpl.srp,
                        fpl.wsp,
                        fpl.promo,
                        fpl.lto_registration,
                        fpl.status,
                        st.status_name,
                        fpl.pricelist_line_id,
                        fpl.inventory_item_id
                FROM ipc_dms.fs_pricelist_lines fpl
                    LEFT JOIN ipc_dms.ipc_fros_vehicles_v vehicle
                        ON vehicle.inventory_item_id = fpl.inventory_item_id
                    LEFT JOIN ipc_dms.fs_status st
                        ON st.status_id = fpl.status
                WHERE 1 = 1
                    AND fpl.pricelist_header_id = :pricelist_header_id";
        
        $params = [
            'pricelist_header_id' => $pricelist_header_id
        ];
        
        $query = DB::select($sql,$params);

        return $query;
    }
    
    public function update_line($params){
        $this
            ->where([
                [ 'pricelist_line_id', '=' , $params['pricelist_line_id'] ],
            ])
            ->update([
                'srp'                   => $params['srp'],
                'wsp'                   => $params['wsp'],
                'lto_registration'      => $params['lto_registration'],
                'promo'                 => $params['promo'],
                'status'                => $params['status'],
                'updated_by'            => $params['updated_by'],
                'update_user_source_id' => $params['update_user_source_id']
            ]);
    }

    public function get_vehicle_price($pricelist_header_id, $inventory_item_id, $vehicle_source_id){
        $sql = "SELECT fpl.pricelist_line_id,
                        fpl.srp,
                        fpl.wsp,
                        fpl.promo,
                        fpl.lto_registration,
                        fpl.pricelist_header_id
                FROM ipc_dms.fs_pricelist_lines fpl
                    INNER JOIN ipc_dms.fs_pricelist_header fph
                        ON fph.pricelist_header_id = fpl.pricelist_header_id
                  
                WHERE 1 = 1
                    AND fpl.inventory_item_id = :inventory_item_id
                    
                    AND fph.pricelist_header_id = :pricelist_header_id
                    AND fpl.vehicle_source_id = :vehicle_source_id
                    AND fph.status = 1
                    AND fpl.status = 1";
        $params = [
            'inventory_item_id'   => $inventory_item_id,
            'pricelist_header_id' => $pricelist_header_id,
            'vehicle_source_id' => $vehicle_source_id,
        ];

        $query = DB::select($sql,$params);
        
        return !empty($query) ? $query[0] : [];
        //return $query[0];
    }
}
