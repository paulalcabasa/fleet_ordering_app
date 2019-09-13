<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDeliverySchedule;
use App\Models\RequirementLine;


class RequirementController extends Controller
{

   
    public function deleteRequirement(
        Request $request, 
        ProjectDeliverySchedule $m_delivery_sched,
        RequirementLine $m_requirement_line
    ){
        $requirement_line_id = $request->requirement_line_id;

        // delete delivery schedule
        $m_delivery_sched->deleteSchedByRequirement($requirement_line_id);
        $m_requirement_line->deleteRequirement($requirement_line_id);
        
        return $requirement_line_id;

    }
}
