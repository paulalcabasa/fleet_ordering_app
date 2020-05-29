<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class POLines extends Model
{
    protected $table = "IPC_DMS.FS_PO_LINES";
    protected $connection = "oracle";

    public function insert_po_lines($params){
        //$this->insert($params);
        $id = $this->insertGetId($params,'po_line_id');
        return $id;
    }

    public function get_po_lines($po_header_id){
        $sql = "SELECT vehicle.sales_model,
                        vehicle.color,
                        fpc_item.suggested_retail_price - fpc_item.promo - fpc_item.discount fleet_price,
                        rl.quantity,
                        pl.po_quantity,
                        rh.vehicle_type,
                        rl.requirement_line_id,
                        pl.po_line_id,
                        vehicle.model_variant,
                        fpc_item.suggested_retail_price,
                        fpc_item.promo,
                        fpc_item.discount
                FROM ipc_dms.fs_po_lines pl
                    LEFT JOIN ipc_dms.fs_prj_requirement_lines rl
                        ON rl.requirement_line_id = pl.requirement_line_id
                    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON rh.requirement_header_id = rl.requirement_header_id
                    LEFT JOIN ipc_dms.ipc_vehicle_models_v vehicle
                        ON vehicle.inventory_item_id = rl.inventory_item_id
                    LEFT JOIN ipc_dms.fs_fpc_items fpc_item
                        ON fpc_item.requirement_line_id = rl.requirement_line_id
                     LEFT JOIN Ipc_dms.fs_fpc_projects fpc_project
                        ON fpc_project.fpc_project_id = fpc_item.fpc_project_id
                     LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_project.fpc_id
                WHERE 1 = 1
                    AND pl.po_header_id = :po_header_id
                    AND fpc.status = 4
                    AND rh.status = 4";
        $params = [
            'po_header_id' => $po_header_id
        ];
        $query = DB::select($sql,$params);
        return $query;
    }
}
