<?php

namespace App\Helpers;

class FPCHelper
{
    public function editable($status)
    {
        $flag = true;

        switch($status){
            case 'Approved' :
                $flag = false;
            break;
            case 'In Progress' :
                $flag = true;
            break;
            case 'Cancelled' :
                $flag = false;
            break;
        }

        return $flag;
    }
}