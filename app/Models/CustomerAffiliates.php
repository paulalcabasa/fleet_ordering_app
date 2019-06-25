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
	

}
