<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SalesOrderHeader extends Model
{
    protected $table = "apps.oe_order_headers_all";
    protected $connection = "oracle";

    public function get_so_headers($sales_order_number, $customer_id){
        $sql = "SELECT ooha.order_number,
                        ott.name order_type_name,
                        ott.description order_type_desc,
                        to_char(ooha.ordered_date, 'MM/DD/YYYY HH12:MI AM') ordered_date,
                        qlh.name price_list_name,
                        qlh.description price_list_desc,
                        ooha.invoice_to_org_id,
                        ooha.sold_to_org_id,
                        cust.party_name,
                        cust.account_name,
                        cust.profile_class,
                        ooha.flow_status_code,
                        ooha.payment_term_id,
                        rt.name payment_term,
                        ooha.header_id
                FROM apps.oe_order_headers_all ooha
                    INNER JOIN apps.oe_transaction_types_tl ott
                        ON ott.transaction_type_id = ooha.order_type_id
                    INNER JOIN  qp.qp_list_headers_tl qlh
                        ON qlh.list_header_id = ooha.price_list_id 
                    INNER JOIN ipc_dms.oracle_customers_v cust
                        ON cust.cust_account_id = ooha.sold_to_org_id
                        AND ooha.invoice_to_org_id = cust.site_use_id
                    INNER JOIN apps.ra_terms_tl rt
                        ON rt.term_id = ooha.payment_term_id
                WHERE 1 = 1
                    AND ooha.order_number = :order_number
                    AND ooha.sold_to_org_id = :customer_id
                    AND ott.transaction_type_id IN (
                        1124,
                        1241,
                        1361,
                        1362,
                        1363
                    )";
        $params = [
            'order_number' => $sales_order_number,
            'customer_id' => $customer_id
        ];

        $query = DB::select($sql,$params);
        return !empty($query) ? $query[0] : $query;
    }

    public function get_so_data_by_id($fwpc_id){
        $sql = "SELECT ooha.order_number,
                        ott.name order_type_name,
                        ott.description order_type_desc,
                        to_char(ooha.ordered_date, 'MM/DD/YYYY HH12:MI AM') ordered_date,
                        qlh.name price_list_name,
                        qlh.description price_list_desc,
                        ooha.invoice_to_org_id,
                        ooha.sold_to_org_id,
                        cust.party_name,
                        cust.account_name,
                        cust.profile_class,
                        ooha.flow_status_code,
                        ooha.payment_term_id,
                        rt.name payment_term,
                        ooha.header_id
                FROM ipc_dms.fs_fwpc fwpc
                    INNER JOIN apps.oe_order_headers_all ooha
                        ON fwpc.sales_order_header_id = ooha.header_id 
                    INNER JOIN apps.oe_transaction_types_tl ott
                        ON ott.transaction_type_id = ooha.order_type_id
                    INNER JOIN  qp.qp_list_headers_tl qlh
                        ON qlh.list_header_id = ooha.price_list_id 
                    INNER JOIN ipc_dms.oracle_customers_v cust
                        ON cust.cust_account_id = ooha.sold_to_org_id
                        AND ooha.invoice_to_org_id = cust.site_use_id
                    INNER JOIN apps.ra_terms_tl rt
                        ON rt.term_id = ooha.payment_term_id
                WHERE 1 = 1
                    AND fwpc.fwpc_id = :fwpc_id";
        $params = [
            'fwpc_id' => $fwpc_id
        ];

        $query = DB::select($sql,$params);
        return !empty($query) ? $query[0] : $query;
    }
}
