<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactPersons extends Model
{
    //
	protected $table = "IPC_DMS.FS_PROJECT_CONTACT_PERSONS";
    protected $connection = "oracle";

    public function insert_contact_persons($params){
    	$this->insert($params);
    }
}
