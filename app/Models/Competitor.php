<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_COMPETITORS";
    protected $connection = "oracle";

    public function insert_competitor($params){
		$this->insert($params);
    }
}
