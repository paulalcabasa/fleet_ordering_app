<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "IPC_DMS.FS_PROJECTS";
	protected $connection = "oracle";

	public function insert_project($params){
    	$id = $this->insertGetId($params,'project_id');
    	return $id;
    }
}
