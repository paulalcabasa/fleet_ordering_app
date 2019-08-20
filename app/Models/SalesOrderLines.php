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

    public function get_fwpc_lines($fpc_project_id){
        $sql = "SELECT vehicle.sales_model,
                        rl.quantity,
                        fpc_item.fleet_price - nvl(sum(freebies.amount),0) fleet_price,
                        (fpc_item.fleet_price - nvl(sum(freebies.amount),0) ) * (fpc_item.dealers_margin/100) dealer_margin,
                        fs_term.term_name,
                        fpc_item.lto_registration,
                        sum(freebies.amount) freebies,
                        vehicle.color
                FROM ipc_dms.fs_fpc_items fpc_item
                    LEFT JOIN ipc_dms.fs_prj_requirement_lines rl
                        ON rl.requirement_line_id = fpc_item.requirement_line_id
                    LEFT JOIN ipc_dms.ipc_vehicle_models_v vehicle
                        ON rl.inventory_item_id = vehicle.inventory_item_id
                     LEFT JOIN ipc_dms.fs_fpc_item_freebies freebies
                        ON freebies.fpc_item_id = fpc_item.fpc_item_id
                     LEFT JOIN ipc_dms.fs_fpc_projects fpc_prj
                        ON fpc_prj.fpc_project_id = fpc_item.fpc_project_id
                     LEFT JOIN ipc_dms.fs_payment_terms fs_term
                        ON fs_term.term_id = fpc_prj.payment_terms
                WHERE fpc_item.fpc_project_id =:fpc_project_id
                GROUP BY 
                        vehicle.sales_model,
                        rl.quantity,
                        fpc_item.fleet_price,
                        fpc_item.dealers_margin,
                        fs_term.term_name,
                        fpc_item.lto_registration,
                        vehicle.color";
        $params = [
            'fpc_project_id' => $fpc_project_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }
}
