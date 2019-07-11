<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDeliverySchedule;

class DeliveryScheduleController extends Controller
{
    //
    public function ajax_get_delivery_detail(Request $request, ProjectDeliverySchedule $m_delivery_sched){
        $requirement_line_id = $request->requirement_line_id;
        $delivery_sched = $m_delivery_sched->get_delivery_schedule($requirement_line_id);
        return $delivery_sched;
        //return ["data" => 'test'];
    }


}
