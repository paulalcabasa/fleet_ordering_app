<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    //
    protected $table = "IPC_DMS.DEALERS_V";
    protected $connection = "oracle";
    protected $primaryKey = 'cust_account_id';

    public function dealer_principal()
    {
        return $this->hasMany('App\Models\DealerPrincipal', 'cust_account_id', 'dealer_id');
    } 
}
