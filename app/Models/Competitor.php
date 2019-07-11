<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Competitor extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_COMPETITORS";
    protected $connection = "oracle";

    public function insert_competitor($params){
		$this->insert($params);
    }

    public function get_competitors($project_id){
    	$sql = "SELECT fpc.competitor_id,
			            fpc.project_id,
			            fpc.brand,
			            fpc.model,
			            fpc.price,
			            fa.directory,
			            fa.orig_filename,
			            fa.filename
				FROM ipc_dms.fs_project_competitors fpc
				    LEFT JOIN ipc_dms.fs_file_attachments fa 
				        ON fpc.competitor_id = fa.reference_id
				        AND fa.reference_table = 'fs_project_competitors'
				        AND fa.reference_column = 'competitor_id'
				WHERE 1 = 1
					AND fpc.project_id = :project_id";

		$params = [
			'project_id' => $project_id
		];

        $query = DB::select($sql,$params);

        return $query;
    }
}
