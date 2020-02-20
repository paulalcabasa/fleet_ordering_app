<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProjectSources extends Model
{
    //
	protected $table = "IPC_DMS.FS_PROJECT_SOURCES";
	protected $connection = "oracle";
    protected $fillable = [
        'source_name'
    ];
    public $timestamps = false;
    protected $primaryKey  = 'project_source_id';

	public function get_project_sources_options(){
    	$data = DB::select('SELECT project_source_id id, source_name text FROM ipc_dms.FS_PROJECT_SOURCES');
    	return $data;
    }

    public function insert_project_source($params){
		$attrs = 
            // this will used for insert
            [
                'source_name' => $params['source_name']
            ];
        $values = 
            // this will be used for other parameters to insert
            [
                'source_name' => $params['source_name']
            ];
		$data = Model::updateOrCreate($attrs,$values);
		return $data->project_source_id;
		
		//$id = $this->insertGetId($params,'project_source_id');
    	//return $id;
    }
}
