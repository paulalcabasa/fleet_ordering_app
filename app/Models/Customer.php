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
                ->selectRaw(DB::raw('distinct customer_name'))
                ->whereRaw("lower(customer_name) like '%".strtolower($customer_name)."%' and status = '1'")
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
                    fot.name org_type_name
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


}
