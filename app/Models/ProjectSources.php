<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProjectSources extends Model
{
    //
	protected $table = "IPC_DMS.FS_PROJECT_SOURCES";
	protected $connection = "oracle";

	public function get_project_sources_options(){
    	$data = DB::select('SELECT project_source_id id, source_name text FROM ipc_dms.FS_PROJECT_SOURCES');
    	return $data;
    }

    public function insert_project_source($params){
    	$id = $this->insertGetId($params,'project_source_id');
    	return $id;
    }
}
