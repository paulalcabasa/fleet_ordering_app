<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPersons extends Model
{
    //
	protected $table = "IPC_DMS.FS_PROJECT_CONTACT_PERSONS";
    protected $connection = "oracle";

    public function insert_contact_persons($params){
    	$this->insert($params);
    }

    public function get_contact_persons($project_id){
		$query = $this
			->where('project_id', $project_id)
			->get();
		return $query;
	}
}
