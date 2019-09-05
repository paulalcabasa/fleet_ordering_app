<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDeliverySchedule;
use Carbon\Carbon;
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

            if($row['owner_id'] == 5){

                $attrs = 
                // this will used for insert
                [
                    'delivery_schedule_id' => $row['delivery_schedule_id']
                ];
                $values = 
                // this will be used for other parameters to insert
                [
                    'delivery_date'         => $row['delivery_date'],
                    'owner_id'              => $row['owner_id'],
                    'quantity'              => $row['quantity'],
                    'requirement_line_id'   => $row['requirement_line_id'],
                    'created_by'            => session('user')['user_id'],
                    'create_user_source_id' => session('user')['source_id'],
                    'module_id'             => 1
                ];
                $m_delivery_sched->insertSched($attrs,$values); 
            }
            /*$m_delivery_sched->update_delivery_schedule(
                $row['suggested_delivery_date'],
                session('user')['user_id'],
                session('user')['source_id'],
                $row['requirement_line_id']
            );*/
        }

    }

    public function deleteSchedule(
        Request $request,
        ProjectDeliverySchedule $m_delivery_sched
    ){
        $delivery_schedule_id = $request->delivery_schedule_id;
        $m_delivery_sched->deleteSchedule($delivery_schedule_id);
    }


}
