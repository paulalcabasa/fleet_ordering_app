<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FPCItemFreebies extends Model
{
    //
    protected $table = "IPC_DMS.FS_FPC_ITEM_FREEBIES";
    protected $connection = "oracle";

    public function get_item_freebies($fpc_item_id){
        $sql = "SELECT freebie_id,
                        fpc_item_id,
                        description,
                        amount,
                        null deleted
                FROM ipc_dms.fs_fpc_item_freebies 
                WHERE 1 = 1
                    AND fpc_item_id = :fpc_item_id";
        $params = [
            'fpc_item_id' => $fpc_item_id
        ];
        $query = DB::select($sql,$params);
        return $query;
    }
    
    public function create_freebies($fpc_item_id, $description, $amount, $user_id, $user_source_id, $date_created){
        $this->updateOrInsert(
                [
                    'description' => $description
                ],
                [
                    'fpc_item_id'           => $fpc_item_id,
                    'description'           => $description,
                    'amount'                => $amount,
                    'created_by'            => $user_id,
                    'updated_by'            => $user_id,
                    'create_user_source_id' => $user_source_id,
                    'creation_date'         => $date_created,
                    'update_user_source_id' => $user_source_id
                ]
            );
    }

    public function delete_freebie($freebie_id){
        $this->where([
            [ 'freebie_id', '=', $freebie_id ]
        ])->delete();
    }
}
