<?php

namespace App\Helpers;

class VehicleTypeIdentification
{
    public function get_vehicle_type($user_type_id)
    {
        if($user_type_id == 32) {
            return 'LCV';    
        }
        else if($user_type_id == 33) {
            return 'CV';
        }
    }
}