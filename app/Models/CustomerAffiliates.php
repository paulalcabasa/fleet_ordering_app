<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CustomerAffiliates extends Model
{
	protected $table = "IPC_DMS.FS_CUSTOMER_AFFILIATES";
	protected $connection = "oracle";

	public function insert_affiliates($params){
		$this->insert($params);
	}

	public function get_affiliate($customer_id){
		$query = $this
					->select('customer_affiliate_id')
					->where('customer_id','=',$customer_id)
					->get()
					->pluck('customer_affiliate_id');
		return $query;
	}

	public function delete_affiliate($customer_id){
		$this->where('customer_id', '=', $customer_id)->delete();
	}

	public function get_customer_affiliates($customer_id){
		$sql = "SELECT fca.affiliate_id,
				        fc.customer_name,
				        fca.customer_id
				FROM ipc_dms.fs_customer_affiliates fca
					LEFT JOIN ipc_dms.fs_customers fc
						ON fc.customer_id = fca.customer_affiliate_id
				WHERE 1 = 1
					AND fca.customer_id = :customer_id";
		
		$params = [
            'customer_id' => $customer_id
        ];

        $query = DB::select($sql,$params);
        return $query;

	}
	

}
