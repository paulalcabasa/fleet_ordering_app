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

    public function getTaggedUnits(){

        $where = "";
        $user_type = session('user')['user_type_id'];
     
    	
        if($user_type == 27 || $user_type == 31) { //  Fleet LCV User
    		$where .= "AND cust.cust_account_id = " . session('user')['customer_id'];
    	
        }

        
        $sql = "SELECT cust.cust_account_id,
                        cust.account_name,
                        cust.profile_class,
                        msn.serial_number,
                        vehicle.sales_model || ' ' || oola.attribute1 sales_model,
                        vehicle.color,
                        ooha.order_number,
                        oola.line_number,
                        TO_CHAR(mr.creation_date,'MM/DD/YYYY HH:MI:SS AM') reservation_date,
                        msn.attribute1 csr_number,
                        msn.attribute14 csr_date,
                        msn.attribute2 vin_number,
                        round(sysdate - mr.creation_date) aging,
                        msib.attribute11 || ' / ' || msn.attribute3 engine,
                        ott.name order_type,
                        rtt.name terms,
                        msn.attribute6 key_number,
                        replace(ooha.attribute3, Chr(39), '')     fleet_account
                FROM apps.mtl_reservations mr
                    LEFT JOIN apps.oe_order_lines_all oola
                        ON mr.demand_source_line_id = oola.line_id
                    LEFT JOIN apps.oe_order_headers_all ooha
                        ON ooha.header_id = oola.header_id
                    LEFT JOIN ipc_dms.ipc_vehicle_models_v vehicle
                        ON vehicle.inventory_item_id = oola.inventory_item_id
                        AND vehicle.organization_id = oola.ship_from_org_id
                    LEFT JOIN ipc_dms.oracle_customers_v cust
                        ON cust.site_use_id = oola.invoice_to_org_id
                        -- ON cust.cust_account_id = oola.sold_to_org_id
                    INNER JOIN mtl_serial_numbers msn
                        ON msn.reservation_id = mr.reservation_id
                        LEFT JOIN oe_transaction_types_tl ott
                        ON ott.transaction_type_id = ooha.order_type_id
                    LEFT JOIN apps.mtl_system_items_b msib
                        ON msib.inventory_item_id = msn.inventory_item_id
                        AND msib.organization_id = msn.current_organization_id
                    LEFT JOIN apps.ra_terms_tl rtt
                        ON rtt.term_id = oola.payment_term_id
                WHERE 1 = 1
                    AND cust.profile_class = 'Dealers-Fleet'
                    $where
                    AND ott.transaction_type_id IN ( 
                            1281,
                            1321,
                            1261,
                            1121,
                            1122,
                            1151,
                            1124,
                            1361,
                            1362,
                            1363
                        )";
        $query = DB::select($sql);
        return $query;
    }

    public function getInvoices($params){

        $customer_filter = "";
        $where = "";
        $user_type = session('user')['user_type_id'];

        if($user_type == 27 || $user_type == 31) { //  Fleet LCV User
            $where .= "AND hcaa.cust_account_id = " . session('user')['customer_id'];    	
        }

		$sql = "SELECT distinct 
						rcta.customer_trx_id,
                       hcaa.account_number,
                       hp.party_name customer_name,
                       NVL(hcaa.account_name,  hp.party_name) account_name,
                       hcpc.name profile_class,
                       ooha.attribute3                     fleet_name,
                       ottl.description                    sales_type,
                       rcta.attribute3 cs_number,
                       msib.attribute9 || ' ' || oola.attribute1 sales_model,
                       msib.attribute8 body_color,
                       ottt.description order_type,
                       rcta.trx_number,
                       to_char(rcta.trx_date,'MM/DD/YYYY') trx_date,
                       to_char(rcta.creation_date,'MM/DD/YYYY HH:MI:SS AM') creation_date,
                       rcta.purchase_order,
                       rtl.name                            payment_terms,
                       ooha.order_number,
                       to_char(ooha.ordered_date,'MM/DD/YYYY') ordered_date,
                       rcta.attribute5                 pullout_date,
                      CASE  WHEN rcta.attribute5 IS NOT NULL THEN to_date(rcta.attribute5, 'YYYY/MM/DD HH24:MI:SS')  + (NVL(SUBSTR( rtl.name, 0, INSTR( rtl.name, ' ')-1),  rtl.name) ) ELSE NULL END due_date,
                        rcta.attribute4                     wb_number,
                       rcta.attribute8                     csr_number,
                       rcta.attribute11                    csr_date,
                       apps.IPC_GET_VEHICLE_VARIANT(msib.segment1) model_variant,
                       CASE WHEN (NVL(araa.amount_applied,0) + 1) > ( (rctla.net_amount + rctla.vat_amount) - (ROUND (rctla.net_amount * .01, 2))) THEN 'PAID' ELSE 'UNPAID' END PAYMENT_STATUS,
                       CASE WHEN (NVL(araa.amount_applied,0) + 1) > ( (rctla.net_amount + rctla.vat_amount) - (ROUND (rctla.net_amount * .01, 2))) THEN  araa.apply_date ELSE NULL END paid_date
                FROM ra_customer_trx_all rcta
                       LEFT JOIN ipc_ar_invoices_with_cm cm
                          ON rcta.customer_trx_id = cm.orig_trx_id
                       LEFT JOIN (SELECT customer_trx_id,
                                         MAX(warehouse_id) warehouse_id,
                                         MAX(inventory_item_id) inventory_item_id,
                                         MAX(quantity_invoiced) quantity_invoiced,
                                         SUM (LINE_RECOVERABLE) net_amount,
                                         SUM (TAX_RECOVERABLE) vat_amount
                                    FROM ra_customer_trx_lines_all
                                   WHERE line_type = 'LINE'
                                GROUP BY customer_trx_id) rctla
                          ON rcta.customer_trx_id = rctla.customer_trx_id
                       LEFT JOIN hz_cust_accounts_all hcaa
                          ON rcta.sold_to_customer_id = hcaa.cust_account_id
                       LEFT JOIN hz_customer_profiles hzp
                          ON hcaa.cust_account_id = hzp.cust_account_id
                           AND rcta.bill_to_site_use_id = hzp.site_use_id
                       LEFT JOIN hz_cust_profile_classes hcpc
                           ON hzp.profile_class_id = hcpc.profile_class_id
                       LEFT JOIN hz_parties hp 
                           ON hcaa.party_id = hp.party_id
                       LEFT JOIN  mtl_system_items_b msib
                            ON rctla.warehouse_id = msib.organization_id
                            AND rctla.inventory_item_id = msib.inventory_item_id
                       LEFT JOIN
                         (SELECT applied_customer_trx_id,
                                 SUM (amount_applied) amount_applied,
                                 MAX (apply_date)   apply_date
                            FROM ar_receivable_applications_all
                           WHERE display = 'Y'
                        GROUP BY applied_customer_trx_id) araa
                          ON araa.applied_customer_trx_id = rcta.customer_trx_id
                       LEFT JOIN oe_order_headers_all ooha
                          ON rcta.interface_header_attribute1 = ooha.order_number
						LEFT JOIN oe_order_lines_all oola
							ON oola.header_id = ooha.header_id
                        LEFT JOIN oe_transaction_types_tl ottt
                        ON ooha.order_type_id = ottt.transaction_type_id
                       LEFT JOIN ra_terms_tl rtl ON ooha.payment_term_id = rtl.term_id
                       LEFT JOIN oe_transaction_types_tl ottl
                          ON ooha.order_type_id = ottl.transaction_type_id
                WHERE 1 = 1
                	AND rcta.cust_trx_type_id = 1002
                  	AND cm.orig_trx_id IS NULL
                  	{$customer_filter}
                    AND hcpc.name = 'Dealers-Fleet'
                  	AND rcta.trx_date BETWEEN :start_date AND :end_date";

       
        $query = DB::select($sql,$params);
		return $query;     
    }
}
