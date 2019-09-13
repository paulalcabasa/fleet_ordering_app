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

    public function getArrayCommonValues($raw_array){
        $dupes = array();
        natcasesort($raw_array);
        reset($raw_array);
        $old_key   = NULL;
        $old_value = NULL;
        foreach ($raw_array as $key => $value) {
            if ($value === NULL) { continue; }
            if (strcasecmp($old_value, $value) === 0) {
                $dupes[$old_key] = $old_value;
                $dupes[$key]     = $value;
            }
            $old_value = $value;
            $old_key   = $key;
        }
        return $dupes;
    }
}