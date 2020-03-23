<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealerPrincipal extends Model
{
    protected $connection = 'oracle';
    protected $table = 'ipc_dms.fs_dealer_principals';
    protected $primaryKey = 'principal_id';
    public $timestamps = false;
    protected $fillable = ['
        name,
        mobile_no,
        email_address,
        position,
        dealer_id,
        status,
        created_by,
        create_user_source,
        creation_date
    '];

    public function dealer(){
        return $this->belongsTo('App\Models\Dealer','dealer_id','cust_account_id');
    }
}
