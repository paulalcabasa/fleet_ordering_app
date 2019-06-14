<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    //
    protected $table = "IPC_DMS.FS_VEHICLE_TYPES";
	protected $connection = "oracle"; 
}
