<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //
    protected $table = "IPC_DMS.FS_FILE_ATTACHMENTS";
    protected $connection = "oracle";

    public function insert_attachment($params){
		$this->insert($params);
    }

    public function get_attachments($customer_id){
		$query = $this
					->where('reference_id','=',$customer_id)
					->get();
		return $query;
	}

	public function get_customer_attachments($customer_id) {
		$query = $this
					->where([
						[ 'reference_id', '=', $customer_id ],
						[ 'reference_table', '=', 'fs_customers' ],
						[ 'reference_column', '=', 'customer_id' ]
					])
					->get();
		return $query;
	}

	public function delete_attachment($customer_id){
		$this->where([
			[ 'reference_id', '=', $customer_id ],
			[ 'reference_table', '=', 'fs_customers' ],
			[ 'reference_column', '=', 'customer_id' ]
		])->delete();
	}

	
}
