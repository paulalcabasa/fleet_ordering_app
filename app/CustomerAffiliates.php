<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CustomerAffiliates extends Model
{
	protected $table = "IPC_DMS.FS_CUSTOMER_AFFILIATES";
	protected $connection = "oracle";

	public function insert_affiliates($params){
		$this->insert($params);
	}
}
