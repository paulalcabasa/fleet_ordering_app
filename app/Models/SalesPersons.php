<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SalesPersons extends Model
{
    //
    protected $table = "t_crm_sales_exec";
    protected $connection = "crms";

    public function get_sales_persons($customer_id){
    	$sql = "SELECT code_item.description,
					se.position,
					se.fname,
					se.mname,
					se.lname,
					se.nickname
				FROM t_crm_sales_exec se
				    LEFT JOIN t_crm_customer_ifs_oracle ora_cust
				       ON se.dealer_id = ora_cust.dealer_code
				    LEFT JOIN t_aum_code_item code_item
					ON code_item.code = se.position
					AND code_item.type = :item_type
				WHERE 1 = 1
					AND ora_cust.account_code = :customer_id
					AND se.status = :status_name";

		$params = [
			'item_type' => 'se_position',
			'customer_id' => $customer_id,
			'status_name' => 'ACT'
		];

		$query = DB::connection('crms')->select($sql,$params);
		return $query;
    }

    public function get_sales_person_options($customer_id){
    	$sql = "SELECT se.db_id id,
					CONCAT(se.fname,' ', se.lname, ' - ', code_item.description) text
				FROM t_crm_sales_exec se
				    LEFT JOIN t_crm_customer_ifs_oracle ora_cust
				       ON se.dealer_id = ora_cust.dealer_code
				    LEFT JOIN t_aum_code_item code_item
					ON code_item.code = se.position
					AND code_item.type = :item_type
				WHERE 1 = 1
					AND ora_cust.account_code = :customer_id
					AND se.status = :status_name";
		$params = [
			'item_type' => 'se_position',
			'customer_id' => $customer_id,
			'status_name' => 'ACT'
		];

		$query = DB::connection('crms')->select($sql,$params);
		return $query;
    }

    public function get_sales_person_details($sales_person_id){
    	$sql = "SELECT code_item.description,
					se.position,
					se.fname,
					se.mname,
					se.lname,
					se.nickname,
					se.email_1,
					se.mobile_1
				FROM t_crm_sales_exec se
				    LEFT JOIN t_crm_customer_ifs_oracle ora_cust
				       ON se.dealer_id = ora_cust.dealer_code
				    LEFT JOIN t_aum_code_item code_item
					ON code_item.code = se.position
					AND code_item.type = :item_type
				WHERE 1 = 1
					AND se.db_id = :sales_person_id
					AND se.status = :status_name";

		$params = [
			'item_type' => 'se_position',
			'sales_person_id' => $sales_person_id,
			'status_name' => 'ACT'
		];

		$query = DB::connection('crms')->select($sql,$params);
		return $query;
    }

}
