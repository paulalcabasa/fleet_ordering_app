<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model
{

    protected $table = "IPC_DMS.FS_CUSTOMERS";
    protected $connection = "oracle";

    public function get_scope_of_business($scope_of_business){
    	$query = DB::connection('oracle')
    			->table('hz_class_code_denorm')
    			->selectRaw(DB::raw('distinct class_code_description, class_code'))
    			->whereRaw("lower(class_code_description) like '%".strtolower($scope_of_business)."%' and enabled_flag = 'Y'")
    			->limit(5)
                ->get();
    	return $query;
    }

    public function get_customer_options(){
        $data = DB::select('SELECT customer_id id, customer_name text FROM ipc_dms.FS_CUSTOMERS WHERE status = 1');
        return $data;
    }

    public function get_customer_names(){
        $data = DB::select('SELECT customer_name FROM ipc_dms.FS_CUSTOMERS where status = 1');
        return  ($data);
    }

    public function insert_customer($params){
        $id = $this->insertGetId($params,'customer_id');
        return $id;
    }

}
