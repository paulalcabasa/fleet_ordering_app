<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPersonsOra extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_SALES_PERSONS";
	protected $connection = "oracle";

    public function insert_sales_person($params){
    	$this->insert($params);
    }

    public function get_sales_persons($project_id){
		$query = $this
			->where('project_id', $project_id)
			->get();
		return $query;
	}

    public function delete_sales_person($sales_person_id){
        $this->where([
            [ 'sales_person_id', '=', $sales_person_id ]
        ])->delete();
    }
}
