<?php

namespace App\Repositories;
use App\Models\Approver;
use App\Repositories\ApproverRepositoryInterface;

class ApproverRepository implements ApproverRepositoryInterface 
{
    public function getApprovers()
    {
        $approver = new Approver;
        return $approver->getApprovers();
    }
}