<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class SalesOrderLines extends Model
{
    //
    protected $table = "apps.oe_order_lines_all";
    protected $connection = "oracle";

    public function get_so_lines($fwpc_id){
        $sql = "SELECT 
                    msib.attribute9 sales_model,
                    msib.attribute8 color,
                    oola.unit_list_price,
                    sum(oola.ordered_quantity) quantity
                FROM oe_order_lines_all oola 
                    INNER JOIN oe_order_headers_all ooha
                        ON ooha.header_id = oola.header_id
                    INNER JOIN ipc_dms.fs_fwpc fwpc
                        ON fwpc.sales_order_header_id = oola.header_id
                    INNER JOIN mtl_system_items_b msib
                        ON msib.inventory_item_id = oola.inventory_item_id
                        AND msib.organization_id = oola.ship_from_org_id
                WHERE 1 = 1
                   AND fwpc.fwpc_id = :fwpc_id
                GROUP BY 
                    msib.attribute9,
                    msib.attribute8,
                    oola.unit_list_price";
        $params = [
            'fwpc_id' => $fwpc_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }
}
