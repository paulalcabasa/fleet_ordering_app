<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model
{

    protected $table = "IPC_DMS.FS_CUSTOMERS";
    protected $connection = "oracle";
    protected $fillable = [
        'customer_name',
        'organization_type_id',
        'tin',
        'address',
        'business_style',
        'establishment_date',
        'products',
        'company_overview',
        'status',
        'create_user_source_id',
        'created_by'
    ];
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    protected $primaryKey = 'customer_id';

    public function get_scope_of_business($scope_of_business){
    	$query = DB::connection('oracle')
    			->table('hz_class_code_denorm')
    			->selectRaw(DB::raw('distinct class_code_description'))
    			->whereRaw("lower(class_code_description) like '%".strtolower($scope_of_business)."%' and enabled_flag = 'Y'")
    			->limit(5)
                ->get();
    	return $query;
    }

    public function get_customer_options(){
        $data = DB::select('SELECT customer_id id, 
                                   customer_name text 
                            FROM ipc_dms.FS_CUSTOMERS 
                            WHERE 1 = 1 
                                AND status = 1
                                AND customer_name IS NOT NULL');
        return $data;
    }

    public function get_customer_names(){
        $data = DB::select('SELECT customer_name 
                            FROM ipc_dms.FS_CUSTOMERS 
                            WHERE 1 = 1
                                AND status = 1 
                                AND customer_name IS NOT NULL');
        return  ($data);
    }

    public function insert_customer($customer_attrs,$customer_values){
        // $this->updateOrInsert($customer_attrs,$customer_values);
        // $id = DB::getPDO()->lastInsertId();
        // return $id;
        $data = Model::updateOrCreate($customer_attrs,$customer_values);
        return $data->customer_id;
    }

    public function get_customer_data($customer_name){
        $sql = "customer_id,
                customer_name,
                tin,
                address,
                business_style,
                to_char(establishment_date,'YYYY-MM-DD') establishment_date,
                products,
                company_overview,
                organization_type_id";

        $params = [
            ['customer_name' ,'=', $customer_name],
            ['status', '=', 1]
        ];

        $data = $this
                    ->selectRaw($sql)
                    ->where($params)
                    ->first();
        return $data;
    }

    public function get_customers($customer_name){
        $query = DB::connection('oracle')
                ->table('ipc_dms.fs_customers')
                ->selectRaw(DB::raw('customer_name'))
                ->whereRaw("upper(customer_name) like '".strtoupper($customer_name)."%' and status = '1'")
                ->limit(5)
                ->get();
        return $query;
    }

    public function get_affiliate_options($customer_name){
        $query = DB::connection('oracle')
                ->table('ipc_dms.fs_customers')
                ->selectRaw(DB::raw('customer_id, customer_name'))
                ->whereRaw("lower(customer_name) like '".strtolower($customer_name)."%' and status = 1")
                ->limit(10)
                ->get();
        return $query;
    }

    public function get_all_customers($user_type,$dealer_id){

        $dealer_filter = "";
        if(in_array($user_type,array('Dealer Staff','Dealer Manager'))){
            $dealer_filter = "AND fc.customer_id IN (
                                SELECT customer_id
                                FROM ipc_dms.fs_projects fp
                                WHERE dealer_id = $dealer_id
                            )";  
        }

        $sql = "SELECT 
                    fc.customer_id,
                    fc.customer_name,
                    fc.tin,
                    fst.status_name,
                    org.name org_type,
                    fst.status_id
                FROM ipc_dms.fs_customers fc
                    LEFT JOIN ipc_dms.fs_organization_types org
                        ON fc.organization_type_id = org.organization_type_id
                    LEFT JOIN ipc_dms.fs_status fst
                        ON fst.status_id = fc.status
                WHERE fc.status = 1
                    $dealer_filter";
    
        $query = DB::select($sql);
        return $query;
    }

    public function get_customer_details_by_id($customer_id){

        $sql = "SELECT 
                    fc.customer_id,
                    fc.customer_name,
                    fc.tin,
                    fc.address,
                    fc.business_style,
                    to_char(fc.establishment_date,'MM/DD/YYYY') establishment_date,
                    fc.products,
                    fc.company_overview,
                    fc.organization_type_id,
                    initcap(fot.name) org_type_name
                FROM ipc_dms.fs_customers fc 
                    LEFT JOIN ipc_dms.fs_organization_types fot
                        ON fc.organization_type_id = fot.organization_type_id
                    
                WHERE 1 = 1
                    AND fc.customer_id = :customer_id";

        $params = [
            'customer_id' => $customer_id
        ];

        $query = DB::select($sql,$params);
        return !empty($query) ? $query[0] : $query;

    }

    public function get_project_customers($vehicle_type){
        /*$sql = "SELECT fc.customer_id,
                        fc.customer_name,
                        fc.tin,
                        fc.address,
                        fot.name org_type_name
                FROM ipc_dms.fs_customers fc
                    LEFT JOIN ipc_dms.fs_organization_types fot
                        ON fot.organization_type_id = fc.organization_type_id
                WHERE fc.customer_id IN (
                    SELECT fp.customer_id
                    FROM ipc_dms.fs_projects fp
                        LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                            ON fp.project_id = rh.project_id
                        LEFT JOIN ipc_dms.fs_fpc_projects fpc_prj
                            ON fp.project_id = fpc_prj.project_id
                            AND rh.requirement_header_id = fpc_prj.requirement_header_id
                        LEFT JOIN ipc_dms.fs_fpc fpc
                            ON fpc.fpc_id = fpc_prj.fpc_id
                    WHERE 1 = 1
                        AND fp.status = 11 
                        AND rh.status = 4
                        AND fpc.status NOT IN (12)
                        AND rh.vehicle_type = :vehicle_type)";*/
                        // AND fpc_prj.fpc_project_id IS NULL
        $sql = "SELECT  distinct
                        fc.customer_id,
                        fc.customer_name,
                        fc.tin,
                        fc.address,
                        fot.name org_type_name
                FROM ipc_dms.fs_projects fp
                    INNER JOIN ipc_dms.fs_customers fc
                        ON fp.customer_id = fc.customer_id
                    INNER JOIN ipc_dms.fs_organization_types fot
                        ON fot.organization_type_id = fc.organization_type_id
                    LEFT JOIN ipc_dms.fs_prj_requirement_headers rh
                        ON fp.project_id = rh.project_id
                WHERE 1 = 1
                    AND fp.status = 11
                    AND rh.status = 4
                    AND rh.vehicle_type = :vehicle_type";
        $params = [
            'vehicle_type' => $vehicle_type
        ];
        $query = DB::select($sql,$params);
        return $query;
    }

    public function get_customers_by_project($customer_name){
        /*$sql = "SELECT  fc.customer_id,
                        fc.customer_name
                FROM ipc_dms.fs_customers fc
                WHERE 1 = 1
                    AND fc.customer_id IN (
                        SELECT fp.customer_id
                        FROM ipc_dms.fs_projects fp
                        WHERE 1 = 1 
                    )
                    AND lower(fc.customer_name) like '%".strtolower($customer_name)."%' 
                    AND fc.status = 1
                LIMIT 10";
        $query = DB::select($sql);
        return $query;*/

        $query = DB::connection('oracle')
                ->table('ipc_dms.fs_customers')
                ->selectRaw(DB::raw('customer_id,customer_name'))
                ->whereRaw("lower(customer_name) like '%".strtolower($customer_name)."%' and status = '1'")
                ->whereRaw("customer_id IN (SELECT customer_id FROM ipc_dms.fs_projects)")
                ->limit(5)
                ->get();
        return $query;

    }

    public function findOracleCustomer($search){
        $sql = "SELECT cust_account_id,
                        party_name
                FROM ipc_dms.oracle_customers_v
                WHERE profile_class = 'Dealers-Fleet'
                    AND lower(party_name) LIKE lower('%".$search."%')";
        $query = DB::select($sql);
        return $query;
    }
    

}
