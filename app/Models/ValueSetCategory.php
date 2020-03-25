<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValueSetCategory extends Model
{
    protected $table = "ipc_dms.fs_value_set_categories";
    protected $connection = "oracle";
    protected $primaryKey = 'category_id';
    protected $fillable = ['name'];
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';


    public function value_set_names()
    {
        return $this->hasMany('App\Models\ValueSetName', 'category_id', 'category_id');
    } 

}
