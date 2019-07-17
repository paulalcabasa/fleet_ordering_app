<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FPCItemFreebies extends Model
{
    //
    protected $table = "IPC_DMS.FS_FPC_ITEM_FREEBIES";
    protected $connection = "oracle";

    public function get_item_freebies($fpc_item_id){
        $query = $this
            ->where('fpc_item_id',$fpc_item_id)
            ->get();
        return $query;
    }
}
