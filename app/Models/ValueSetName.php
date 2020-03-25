<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValueSetName extends Model
{
    protected $table = "ipc_dms.fs_value_sets";
    protected $connection = "oracle";
    protected $primaryKey = 'value_set_id';
    protected $fillable = ['
        category_id,
        description,
        create_user,
        create_user_source,
        creation_date,
        update_user,
        update_user_source,
        update_date
    '];
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';

     public function category(){
        return $this->belongsTo('App\Models\ValueSetCategory','category_id','category_id');
    }
}
