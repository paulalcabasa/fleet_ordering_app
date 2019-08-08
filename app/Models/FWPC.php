<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FWPC extends Model
{
    protected $table = "IPC_DMS.FS_FWPC";
    protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

    public function insert_fwpc($params){
        return $this->insertGetId($params,'fwpc_id');
    }

    public function get_fwpc_by_project($project_id){
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
                        ooha.flow_status_code status_name,
                        ooha.payment_term_id,
                        rt.name payment_term,
                        fwpc.FWPC_ID
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
                        AND fwpc.project_id = :project_id";
        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function get_fwpc_by_id($fwpc_id){
        $sql = "SELECT fwpc.fwpc_id,
                        ooha.order_number,
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
                        ooha.flow_status_code status_name,
                        ooha.payment_term_id,
                        rt.name payment_term
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
        return $query[0];
    }

    public function delete_fwpc($fwpc_id){
        $this->where([
            [ 'fwpc_id', '=', $fwpc_id ]
        ])->delete();
    }
}
