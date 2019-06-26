<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_CONTACT";
	protected $connection = "oracle";

	public function insert_contact($params){
		$this->insert($params);
	}

	public function get_contacts($project_id){
		$query = $this
			->where('project_id', $project_id)
			->get();
		return $query;
	}
}
