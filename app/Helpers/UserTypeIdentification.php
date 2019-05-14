<?php

namespace App\Helpers;

class UserTypeIdentification
{
    public function user_guard_type($source_id)
    {
        return $source_id == 1 ? 'oracle_users' : 'web'; 
    }
}