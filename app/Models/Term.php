<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $connection = 'oracle';
    protected $table = 'ipc_dms.fs_payment_terms';
    protected $primaryKey = 'term_id';
    public $timestamps = false;
    protected $fillable = ['term_name,status'];
  
}
