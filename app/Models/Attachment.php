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

	public function delete_competitor_attachment($project_id){
		$this->where([
			[ 'reference_id', '=', $project_id ],
			[ 'reference_table', '=', 'fs_projects' ],
			[ 'reference_column', '=', 'project_id' ],
			[ 'owner_id', '=', 1 ],
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

	public function get_fpc_project_attachments($fpc_project_id){
		$query = $this
					->where([
						[ 'reference_id', '=', $fpc_project_id ],
						[ 'reference_table', '=', 'fs_fpc_projects' ],
						[ 'reference_column', '=', 'fpc_project_id' ],
						[ 'owner_id' , '=' , 7]
					])
					->get();
		return $query;
	}

	public function get_po_attachments($po_header_id){
		$query = $this
					->where([
						[ 'reference_id', '=', $po_header_id ],
						[ 'reference_table', '=', 'fs_po_headers' ],
						[ 'reference_column', '=', 'po_header_id' ],
						[ 'owner_id' , '=' , 4]
					])
					->get();
		return $query;
	}

	public function get_fwpc_attachments($fwpc_id, $owner_id){
		$query = $this
					->where([
						[ 'reference_id', '=', $fwpc_id ],
						[ 'reference_table', '=', 'fs_fwpc' ],
						[ 'reference_column', '=', 'fwpc_id' ],
						[ 'owner_id' , '=' , $owner_id]
					])
					->get();
		return $query;
	}

	public function delete_fwpc_attachment($fwpc_id, $owner_id){
		$this->where([
			[ 'reference_id', '=', $fwpc_id ],
			[ 'reference_table', '=', 'fs_fwpc' ],
			[ 'reference_column', '=', 'fwpc_id' ],
			[ 'owner_id', '=', $owner_id ],
		])->delete();
	}
	
}
