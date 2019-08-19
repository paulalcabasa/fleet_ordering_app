<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDeliverySchedule;

class DeliveryScheduleController extends Controller
{
    //
    public function ajax_get_delivery_detail(
        Request $request, 
        ProjectDeliverySchedule $m_delivery_sched
    ){
        $requirement_line_id = $request->requirement_line_id;
        $delivery_sched      = $m_delivery_sched->get_project_delivery_schedule($requirement_line_id);
        return $delivery_sched;
    }

    public function update_suggested_date(
        Request $request,
        ProjectDeliverySchedule $m_delivery_sched
    ){
        $delivery_details = $request->delivery_details;

        foreach($delivery_details as $row){
            $m_delivery_sched->update_delivery_schedule(
                $row['suggested_delivery_date'],
                session('user')['user_id'],
                session('user')['source_id'],
                $row['requirement_line_id']
            );
        }

    }


}
