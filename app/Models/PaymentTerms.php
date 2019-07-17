<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PaymentTerms extends Model
{
    //
    protected $table = "IPC_DMS.FS_PAYMENT_TERMS";
    protected $connection = "oracle";

    public function get_payment_terms(){
        $query = $this
            ->where('status',1)
            ->get();
        return $query;
    }
}
