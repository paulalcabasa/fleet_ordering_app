<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RequirementLine extends Model
{
    //
    protected $table = "IPC_DMS.FS_PRJ_REQUIREMENT_LINES";
	protected $connection = "oracle";

	public function insert_requirement_line($params){
		$id = $this->insertGetId($params,'requirement_line_id');
    	return $id;
    }

}
