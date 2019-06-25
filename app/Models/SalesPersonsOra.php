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
}
