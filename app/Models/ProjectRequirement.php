<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequirement extends Model
{
    
    protected $table = "IPC_DMS.FS_PROJECT_REQUIREMENTS";
    protected $connection = "oracle";

    public function insert_requirement($params){
		$id = $this->insertGetId($params,'requirement_id');
    	return $id;
    }
}
