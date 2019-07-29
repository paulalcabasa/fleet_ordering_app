<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\RequirementLine;
use App\Models\ProjectDeliverySchedule; 

class PurchaseOrderController extends Controller
{
    public function manage_po(Request $request){
    	$page_data = [
    		'price_confirmation_id' => $request->price_confirmation_id,
            'action' => $request->action
    	];
    	return view('purchase_order.manage_po', $page_data);
    }

    public function all_po(){
    	return view('purchase_order.all_po');
    }

    public function po_approval(){
        return view('purchase_order.po_approval');
    }

    public function submit_po(
        Request $request,
        Project $m_project,
        RequirementLine $m_requirement_line,
        ProjectDeliverySchedule $m_delivery_sched
    ){
        $project_id = $request->project_id;
        $project_details = $m_project->get_details($project_id);
        $requirement_lines = $m_requirement_line->get_requirement_lines($project_id);
        $requirement_lines_data = [];
        foreach ($requirement_lines as $row) {
            $delivery_sched = $m_delivery_sched->get_project_delivery_schedule($row->requirement_line_id); 
            $arr = [
                'requirement_line_id' => $row->requirement_line_id,
                'fleet_price'         => $row->fleet_price,
                'sales_model'         => $row->sales_model,
                'color'               => $row->color,
                'quantity'            => $row->quantity,
                'po_qty'              => $row->po_qty,
                'vehicle_type'        => $row->vehicle_type,
                'delivery_sched'      => $delivery_sched
            ];   
            array_push($requirement_lines_data, $arr);
        }
        $vehicle_colors = config('app.vehicle_badge_colors');
        $status_colors = config('app.status_colors');
       
        $page_data = [
            'project_id'        => $project_id,
            'project_details'   => $project_details,
            'requirement_lines' => $requirement_lines_data,
            'vehicle_colors'    => $vehicle_colors,
            'status_colors'     => $status_colors
        ];
        return view('purchase_order.submit_po', $page_data);
    }
}
