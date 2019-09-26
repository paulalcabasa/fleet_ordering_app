<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDeliverySchedule;
use App\Models\RequirementLine;
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
        }

    }

    public function deleteSchedule(
        Request $request,
        ProjectDeliverySchedule $m_delivery_sched
    ){
        $delivery_schedule_id = $request->delivery_schedule_id;
        $m_delivery_sched->deleteSchedule($delivery_schedule_id);
    }

    public function saveSchedule(
        Request $request,
        ProjectDeliverySchedule $m_delivery_sched,
        RequirementLine $m_rl
    ){
        $delivery_details = $request->delivery_details;
        $requirement_line_id = $request->requirement_line_id;
        $vehicle_details = $request->vehicle_details;

        foreach($delivery_details as $row){
            $attrs = 
            // this will used for insert
            [
                'delivery_schedule_id' => $row['delivery_schedule_id']
            ];
            $values = 
            // this will be used for other parameters to insert
            [
                'delivery_date'         => $row['delivery_date'],
                'owner_id'              => 6,
                'quantity'              => $row['quantity'],
                'requirement_line_id'   => $requirement_line_id,
                'created_by'            => session('user')['user_id'],
                'create_user_source_id' => session('user')['source_id'],
                'module_id'             => 1
            ];
            $m_delivery_sched->insertSched($attrs,$values); 
        }

        $m_rl->updateRequirement($vehicle_details);
        return $m_delivery_sched->get_project_delivery_schedule($requirement_line_id);
    }

    public function savePOSchedule(
        Request $request,
        ProjectDeliverySchedule $m_delivery_sched
    ){
        $delivery_details      = $request->delivery_details;
        $po_line_id            = $request->po_line_id;
        $requirement_line_id   = $request->requirement_line_id;
        $delivery_sched_params = [];
        foreach($delivery_details as $row){
            
            // INSERT
            if(!isset($row['delivery_schedule_id']) && $row['delete_flag'] == 'N'){
                // insert
                $sched_params = [
                    'requirement_line_id'   => $requirement_line_id,
                    'quantity'              => $row['quantity'],
                    'delivery_date'         => $row['delivery_date'],
                    'module_id'             => 2, // purchase order module
                    'owner_id'              => $row['owner_id'],
                    'created_by'            => session('user')['user_id'],
                    'create_user_source_id' => session('user')['source_id'],
                    'creation_date'         => Carbon::now(),
                    'po_line_id'            => $po_line_id
                ];
                array_push($delivery_sched_params, $sched_params);
            }

            // DELETE
            if(isset($row['delivery_schedule_id']) && $row['delete_flag'] == 'Y'){
                $m_delivery_sched->deleteSchedule($row['delivery_schedule_id']);
            }

            // UPDATE
            if(isset($row['delivery_schedule_id']) && $row['delete_flag'] == 'N'){
                $m_delivery_sched->update_delivery_sched([
                    'delivery_schedule_id'  => $row['delivery_schedule_id'],
                    'quantity'              => $row['quantity'],
                    'delivery_date'         => $row['delivery_date'],
                    'updated_by'            => session('user')['user_id'],
                    'update_user_source_id' => session('user')['source_id']
                ]);
            }

        }

        // insert not existing
        $m_delivery_sched->insert_delivery_schedule($delivery_sched_params);   
        return $m_delivery_sched->get_po_delivery_schedule($po_line_id);
    }

    


}
