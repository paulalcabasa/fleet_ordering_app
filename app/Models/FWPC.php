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
        $sql = "SELECT  fwpc.fwpc_id,
                        fwpc.fpc_project_id,
                        fwpc.po_header_id,
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
                        ooha.flow_status_code,
                        ooha.payment_term_id,
                        rt.name payment_term,
                        fs.status_name,
                        ffa_ipc.symlink_dir || ffa_ipc.filename ipc_file,
                        FFA_IPC.ORIG_FILENAME ipc_file_orig,
                        ffa_dlr.symlink_dir || ffa_dlr.filename dlr_file,
                        ffa_dlr.ORIG_FILENAME dlr_file_orig
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
                    LEFT JOIN ipc_dms.fs_status fs 
                        ON fs.status_id = fwpc.status
                    LEFT JOIN ipc_dms.fs_file_attachments ffa_ipc
                        ON ffa_ipc.reference_id = fwpc.fwpc_id
                        AND ffa_ipc.reference_table = 'fs_fwpc'
                        AND ffa_ipc.reference_column = 'fwpc_id'
                        AND ffa_ipc.owner_id  = 5
                    LEFT JOIN ipc_dms.fs_file_attachments ffa_dlr
                        ON ffa_dlr.reference_id = fwpc.fwpc_id
                        AND ffa_dlr.reference_table = 'fs_fwpc'
                        AND ffa_dlr.reference_column = 'fwpc_id'
                        AND ffa_dlr.owner_id  = 6
                WHERE 1 = 1
                        AND fwpc.project_id = :project_id";
        $params = [
            'project_id' => $project_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

/* 
*/
    public function get_fwpc_by_id($fwpc_id){
        $sql = "SELECT fwpc.fwpc_id,
                        fwpc.fpc_project_id,
                        to_char(fwpc.creation_date,'DD-MON-YYYY') creation_date,
                        fwpc.project_id,
                        fc.customer_name,
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
                        rt.name payment_term,
                        terms.term_name payment_terms,
                        fwpc.sales_order_header_id,
                        dbb.abbreviation || 
                        to_char(fwpc.creation_date,'MM') || 
                        to_char(fwpc.creation_date,'YY') || 
                        '-' || 
                        fwpc.fwpc_id fwpc_ref_no,
                        fwpc.po_header_id,
                        usr.email_address,
                        fpc.vehicle_type
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
                    INNER JOIN ipc_dms.fs_projects fp
                        ON fp.project_id = fwpc.project_id
                    INNER JOIN ipc_dms.fs_customers fc
                        ON fc.customer_id = fp.customer_id
                    INNER JOIN ipc_dms.fs_fpc_projects fpc_prj
                        ON fpc_prj.fpc_project_id = fwpc.fpc_project_id
                    INNER JOIN ipc_dms.fs_payment_terms terms
                        ON terms.term_id = fpc_prj.payment_terms
                    LEFT JOIN ipc_dms.dealer_abbrev_names dbb
                        ON dbb.cust_account_id = fp.dealer_id
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fp.created_by
                        AND usr.user_source_id = fp.create_user_source_id
                    LEFT JOIN ipc_dms.fs_fpc fpc
                        ON fpc.fpc_id = fpc_prj.fpc_id
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

    public function update_fwpc_status(
        $fwpc_id, 
        $remarks, 
        $status, 
        $update_user, 
        $user_source_id
    ){
        $this
            ->where([
                [ 'fwpc_id', '=' , $fwpc_id ]
            ])
            ->update([
                'remarks'               => $remarks,
                'status'                => $status,
                'updated_by'            => $update_user,
                'update_user_source_id' => $user_source_id
            ]);
    }

}
