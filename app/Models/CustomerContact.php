<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    //
    protected $table = "IPC_DMS.FS_PROJECT_CONTACT";
	protected $connection = "oracle";

	public function insert_contact($params){
		$this->insert($params);
	}
}
