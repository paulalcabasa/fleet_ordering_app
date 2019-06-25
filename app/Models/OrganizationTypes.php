<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrganizationTypes extends Model
{
    //
    protected $table = "IPC_DMS.FS_ORGANIZATION_TYPES";
    protected $connection = "oracle";

    public function get_org_options(){
    	$orgs = DB::select('SELECT organization_type_id id, initcap(name) text FROM ipc_dms.FS_ORGANIZATION_TYPES');
    	return $orgs;
    }

}
