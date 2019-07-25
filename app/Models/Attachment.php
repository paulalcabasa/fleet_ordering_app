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

	public function get_competitor_attachments($project_id){
		$query = $this
					->where([
						[ 'reference_id', '=', $project_id ],
						[ 'reference_table', '=', 'fs_projects' ],
						[ 'reference_column', '=', 'project_id' ],
						[ 'owner_id' , '=' , 1]
					])
					->get();
		return $query;
	}

	public function get_fpc_attachments($fpc_id){
		$query = $this
					->where([
						[ 'reference_id', '=', $fpc_id ],
						[ 'reference_table', '=', 'fs_fpc' ],
						[ 'reference_column', '=', 'fpc_id' ],
						[ 'owner_id' , '=' , 3]
					])
					->get();
		return $query;
	}

	
}
