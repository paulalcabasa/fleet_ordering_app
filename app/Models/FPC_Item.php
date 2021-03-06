<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FPC_Item extends Model
{
	protected $table = "IPC_DMS.FS_FPC_ITEMS";
	protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

	public function insert_fpc_item($params){
		$this->insert($params);
	}

	public function get_fpc_item_requirements($fpc_project_id){
		$sql = "SELECT  fpc_prj.fpc_id,
				            rh.project_id,
				            fpc_prj.fpc_project_id,
				            rl.requirement_line_id,
				            rl.inventory_item_id,
				            vehicle.price
				FROM ipc_dms.fs_fpc_projects fpc_prj
				    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
				        ON fpc_prj.requirement_header_id = rh.requirement_header_id
				    LEFT JOIN ipc_dms.fs_prj_requirement_lines rl
				        ON rl.requirement_header_id = rh.requirement_header_id
				    LEFT JOIN ipc_dms.ipc_vehicles_with_price_v vehicle
				        ON vehicle.inventory_item_id = rl.inventory_item_id
				WHERE 1 = 1
				    AND fpc_prj.fpc_project_id = :fpc_project_id";

		$params = [
			'fpc_project_id' => $fpc_project_id
		];
		$query = DB::select($sql,$params);
    	return $query;
	}

	public function get_item_requirements($fpc_project_id){
		$sql = "SELECT  fpc_prj.fpc_id,
                        fp.project_id,
                        fpc_prj.fpc_project_id,
                        vehicle.sales_model,
                        vehicle.color,
                        vehicle.model_variant,
                        rl.quantity,
                        nvl(rl.BODY_BUILDER_NAME,'-') body_builder_name,
                        nvl(rl.rear_body_type,'-') rear_body_type,
                        nvl(rl.additional_items,'-') additional_items,
                        sum(CASE WHEN freebie.cost_to_owner_id = 5 THEN NVL(freebie.amount,0) ELSE 0 END) freebies,
                        rl.suggested_price,
                        fpc_item.suggested_retail_price,
                        fpc_item.wholesale_price,
                        fpc_item.dealers_margin,
                        fpc_item.lto_registration,
                        CASE 
                            WHEN fpc_item.fleet_price = 0 THEN (fpc_item.suggested_retail_price - (fpc_item.discount + fpc_item.promo)) 
                            ELSE fpc_item.fleet_price
                        END fleet_price,
                        rl.requirement_line_id,
                        fpc_item.fpc_item_id,
                        rl.inventory_item_id,
                        fpc_item.promo,
                        fpc_item.promo_title,
                        fpc_item.pricelist_header_id,
                        fpc_item.pricelist_line_id,
                        fpc_item.discount,
                        vehicle.vehicle_source_id
                FROM ipc_dms.fs_fpc_projects fpc_prj
                    INNER JOIN IPC_DMS.fs_projects fp
                        ON fpc_prj.project_id = fp.project_id
                    INNER JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON rh.project_id = fp.project_id
                        AND rh.requirement_header_id = fpc_prj.requirement_header_id
                    INNER JOIN ipc_dms.fs_prj_requirement_lines rl
                        ON rl.requirement_header_id = rh.requirement_header_id
                    INNER JOIN ipc_dms.ipc_fros_vehicles_v vehicle
                        ON vehicle.inventory_item_id = rl.inventory_item_id
                        AND vehicle.vehicle_source_id = rl.vehicle_source_id
                    INNER JOIN ipc_dms.fs_fpc_items fpc_item
                        ON fpc_item.fpc_project_id = fpc_prj.fpc_project_id
                       AND fpc_item.requirement_line_id = rl.requirement_line_id
                    LEFT JOIN ipc_dms.fs_fpc_item_freebies freebie
                        ON freebie.fpc_item_id = fpc_item.fpc_item_id
                WHERE 1 = 1
                        AND fpc_prj.fpc_project_id = :fpc_project_id
                GROUP BY
                        fpc_prj.fpc_id,
                        fp.project_id,
                        fpc_prj.fpc_project_id,
                        vehicle.sales_model,
                        vehicle.color,
                        rl.quantity,
                        rl.BODY_BUILDER_NAME,
                        rl.rear_body_type,
                        rl.additional_items,
                        rl.suggested_price,
                        fpc_item.suggested_retail_price,
                        fpc_item.wholesale_price,
                        fpc_item.dealers_margin,
                        fpc_item.lto_registration,
                        fpc_item.fleet_price,
                        rl.requirement_line_id,
                        fpc_item.fpc_item_id,
                        vehicle.model_variant,
                        rl.inventory_item_id,
                        fpc_item.promo,
                        fpc_item.promo_title,
                        fpc_item.pricelist_header_id,
                        fpc_item.pricelist_line_id,
                        fpc_item.discount,
                        vehicle.vehicle_source_id";

		$params = [
			'fpc_project_id' => $fpc_project_id
		];
		$query = DB::select($sql,$params);
    	return $query;
	}

    public function updateFPCItem($params){
        $this
            ->where([
                [ 'fpc_item_id', '=' , $params['fpc_item_id'] ]
            ])
            ->update([
                'dealers_margin'         => $params['dealers_margin'],
                'lto_registration'       => $params['lto_registration'],
                'fleet_price'            => $params['fleet_price'],
                'wholesale_price'        => $params['wholesale_price'],
                'discount'               => $params['discount'],
                'updated_by'             => $params['updated_by'],
                'update_user_source_id'  => $params['update_user_source_id'],
                'suggested_retail_price' => $params['suggested_retail_price'],
                'promo'                  => $params['promo'],
                'promo_title'            => $params['promo_title'],
                'pricelist_header_id'    => $params['pricelist_header_id'],
                'pricelist_line_id'      => $params['pricelist_line_id'],
            ]);
    }

    public function get_items_by_fpc($fpc_id){
        $sql = "SELECT rl.inventory_item_id
                FROM ipc_dms.fs_fpc_projects fpc_prj
                    LEFT JOIN ipc_dms.fs_fpc_items fpc_item
                        ON fpc_item.fpc_project_id = fpc_prj.fpc_project_id
                    LEFT JOIN ipc_dms.fs_prj_requirement_lines rl
                        ON rl.requirement_line_id = fpc_item.requirement_line_id 
                WHERE  fpc_prj.fpc_id = :fpc_id";
        $params = [
            'fpc_id' => $fpc_id
        ];

        $query = DB::select($sql, $params);

        return $query;
    }

    public function get_conflict_item_requirement($fpc_id,$item_ids){
        $query = DB::table('IPC_DMS.FS_FPC_ITEMS AS fpc_item')
            ->leftJoin('ipc_dms.fs_prj_requirement_lines AS rl', 'rl.requirement_line_id', '=', 'fpc_item.requirement_line_id')
            ->leftJoin('ipc_dms.fs_fpc_projects AS fpc_prj', 'fpc_prj.fpc_project_id', '=', 'fpc_item.fpc_project_id')
            ->leftJoin('ipc_dms.ipc_vehicle_models_v AS vehicle', 'vehicle.inventory_item_id', '=', 'rl.inventory_item_id')
            ->leftJoin('ipc_dms.fs_fpc_item_freebies AS fr', 'fr.fpc_item_id', '=', 'fpc_item.fpc_item_id')
            ->selectRaw("vehicle.color,
                         vehicle.model_variant,
                         vehicle.sales_model,
                         max(nvl(rl.BODY_BUILDER_NAME,'-')) body_builder_name,
                         max(nvl(rl.rear_body_type,'-')) rear_body_type,
                         max(nvl(rl.additional_items,'-')) additional_items,
                         sum(CASE WHEN fr.cost_to_owner_id = 5 THEN NVL(fr.amount,0) ELSE 0 END) freebies,
                         fpc_item.wholesale_price,
                         fpc_item.dealers_margin,
                         fpc_item.suggested_retail_price,
                         fpc_item.lto_registration,
                         fpc_item.fleet_price,
                         fpc_item.promo,
                         fpc_item.discount")
            ->where('fpc_prj.fpc_id', '=', $fpc_id)
            ->whereIn('rl.inventory_item_id', $item_ids)
            ->groupBy(  
                        'vehicle.color',
                        'vehicle.model_variant',
                        'vehicle.sales_model',
                       
                        'fpc_item.wholesale_price',
                        'fpc_item.dealers_margin',
                        'fpc_item.lto_registration',
                        'fpc_item.fleet_price',
                        'fpc_item.promo',
                         'fpc_item.discount',
                         'fpc_item.suggested_retail_price' )
            ->get();

            //  'rl.BODY_BUILDER_NAME',
            //            'rl.rear_body_type',
             //           'rl.additional_items',
        return $query;
    }

    public function get_item_requirement_by_fpc_id($fpc_id,$item_ids){
       
        $query = DB::table('IPC_DMS.FS_FPC_ITEMS AS fpc_item')
            ->leftJoin('ipc_dms.fs_prj_requirement_lines AS rl', 'rl.requirement_line_id', '=', 'fpc_item.requirement_line_id')
            ->leftJoin('ipc_dms.fs_fpc_projects AS fpc_prj', 'fpc_prj.fpc_project_id', '=', 'fpc_item.fpc_project_id')
            ->leftJoin('ipc_dms.ipc_vehicle_models_v AS vehicle', 'vehicle.inventory_item_id', '=', 'rl.inventory_item_id')
            ->leftJoin('ipc_dms.fs_fpc_item_freebies AS fr', 'fr.fpc_item_id', '=', 'fpc_item.fpc_item_id')
            ->leftJoin('ipc_dms.fs_projects AS fp', 'fp.project_id', '=', 'fpc_prj.project_id')
            ->leftJoin('ipc_dms.dealers_v AS dlr', 'dlr.cust_account_id', '=', 'fp.dealer_id')
            ->selectRaw("vehicle.color,
                         vehicle.model_variant,
                         vehicle.sales_model,
                         nvl(rl.BODY_BUILDER_NAME,'-') body_builder_name,
                         nvl(rl.rear_body_type,'-') rear_body_type,
                         nvl(rl.additional_items,'-') additional_items,
                         sum(CASE WHEN fr.cost_to_owner_id = 5 THEN NVL(fr.amount,0) ELSE 0 END) freebies,
                         fpc_item.wholesale_price,
                         fpc_item.dealers_margin,
                         fpc_item.lto_registration,
                         fpc_item.suggested_retail_price,
                         fpc_item.fleet_price,
                         fpc_item.fpc_item_id,
                         dlr.account_name dealer_name,
                         rl.quantity,
                         fpc_item.discount,
                         fpc_item.promo,
                         fpc_item.promo_title")
            ->where('fpc_prj.fpc_id', '=', $fpc_id)
            ->whereIn('rl.inventory_item_id', $item_ids)
            ->groupBy(  
                        'vehicle.color',
                        'vehicle.model_variant',
                        'vehicle.sales_model',
                        'rl.BODY_BUILDER_NAME',
                        'rl.rear_body_type',
                        'rl.additional_items',
                        'fpc_item.wholesale_price',
                        'fpc_item.dealers_margin',
                        'fpc_item.lto_registration',
                        'fpc_item.suggested_retail_price',
                        'fpc_item.fleet_price',
                        'fpc_item.fpc_item_id',
                        'dlr.account_name',
                        'rl.quantity',
                        'fpc_item.discount',
                        'fpc_item.promo',
                        'fpc_item.promo_title' )
            ->get();

     
       
        return $query;
    }


}
