<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RequirementHeader extends Model
{
    //
	protected $table = "IPC_DMS.FS_PRJ_REQUIREMENT_HEADERS";
	protected $connection = "oracle";

	public function insert_requirement_header($params){
		$id = $this->insertGetId($params,'requirement_header_id');
    	return $id;
    }


}
