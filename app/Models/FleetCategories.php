<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FleetCategories extends Model
{
    //
    protected $table = "IPC_DMS.FS_FLEET_CATEGORIES";
    protected $connection = "oracle";
}
