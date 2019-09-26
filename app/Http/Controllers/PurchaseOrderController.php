<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\RequirementLine;
use App\Models\ProjectDeliverySchedule; 
use App\Models\POHeaders; 
use App\Models\POLines; 
use Carbon\Carbon;
use App\Models\Attachment;
use App\Models\Approver;
use App\Models\ModuleApproval;
use App\Models\ActivityLogs;
use App\Models\Dealer;


class PurchaseOrderController extends Controller
{
    public function po_overview(
        Request $request,
        POHeaders $m_poh,
        Attachment $m_attachment,
        POLines $m_pol,
        ProjectDeliverySchedule $m_delivery_sched
    ){
        

        $po_header_id = $request->po_header_id;
        $action       = $request->action;

        if($action == "validate" && !in_array(session('user')['user_type_id'], array(32,33)) ){
            return view('errors.404');
        }

        $approval_id  = $request->approval_id;
        $po_details   = $m_poh->get_po_details($po_header_id);
        $attachments  = $m_attachment->get_po_attachments($po_header_id);
        $po_lines     = $m_pol->get_po_lines($po_header_id);
        $po_line_data = [];

        foreach ($po_lines as $row) {

            $delivery_sched = $m_delivery_sched->get_po_delivery_schedule($row->po_line_id); 
            $arr = [
                'requirement_line_id' => $row->requirement_line_id,
                'po_line_id'          => $row->po_line_id,
                'fleet_price'         => $row->fleet_price,
                'sales_model'         => $row->sales_model,
                'color'               => $row->color,
                'quantity'            => $row->quantity,
                'po_quantity'         => $row->po_quantity,
                'vehicle_type'        => $row->vehicle_type,
                'variant'             => $row->model_variant,
                'delivery_sched'      => $delivery_sched
              
            ];   
            array_push($po_line_data, $arr);
        }

        $page_data    = [
            'po_header_id'   => $po_header_id,
            'approval_id'    => $approval_id,
            'action'         => $action,
            'po_details'     => $po_details,
            'attachments'    => $attachments,
            'po_lines'       => $po_line_data,
            'base_url'       => url('/'),
            'status_colors'  => config('app.status_colors'),
            'vehicle_colors' => config('app.vehicle_badge_colors')
        ];
    	return view('purchase_order.po_overview', $page_data);
    }

    public function all_po(POHeaders $m_poh){

     /*   $po_list = $m_poh->get_all_po(
            session('user')['customer_id'], 
            session('user')['user_type_id']
        );*/

        if(in_array(session('user')['user_type_id'], array(32,33)) ){
            $dealers = Dealer::all();
        }
        else {
            $dealers = Dealer::find(session('user')['customer_id']);
        }
     

        $page_data = [
            'status_colors' => config('app.status_colors'),
            'base_url'      => url('/'),
            'dealers'       => $dealers,
            'user_type'     => session('user')['user_type_id'],
            'customer_id'   => session('user')['customer_id'] == null ? "" : session('user')['customer_id']

        ];

    	return view('purchase_order.all_po',$page_data);
    }

    public function submit_po(
        Request $request,
        Project $m_project,
        RequirementLine $m_requirement_line,
        ProjectDeliverySchedule $m_delivery_sched
    ){
        $project_id = $request->project_id;
        $project_details = $m_project->get_details($project_id);
        $requirement_lines = $m_requirement_line->get_po_requirement_lines($project_id);
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
                'delivery_sched'      => $delivery_sched,
                'variant'             => $row->model_variant
            ];   
            array_push($requirement_lines_data, $arr);
        }
       
        $page_data = [
            'project_id'         => $project_id,
            'project_details'    => $project_details,
            'requirement_lines'  => $requirement_lines_data,
            'vehicle_colors'     => config('app.vehicle_badge_colors'),
            'status_colors'      => config('app.status_colors'),
            'base_url'           => url('/'),
            'vehicle_lead_time' => config('app.vehicle_lead_time')
        ];
        return view('purchase_order.submit_po', $page_data);
    }

    public function save_po(
        Request $request,
        POHeaders $m_po_header,
        POLines $m_po_lines,
        Approver $m_approver,
        ModuleApproval $m_approval,
        ProjectDeliverySchedule $m_delivery_sched,
        ActivityLogs $m_activity_logs
    ){
        $requirement_lines = $request->requirement_lines;
        $po_number         = $request->po_number;
        $project_id        = $request->project_id;
        $vehicle_type      = $request->vehicle_type;

        // insert po headers
        $po_header_params = [
            'po_number'             => $po_number,
            'project_id'            => $project_id,
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'status'                => 7 // pending , to be reviewed by ipc
        ];

        $po_header_id = $m_po_header->insert_po_header($po_header_params);

        $activity_log_params = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has submitted a purchase order.',
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'reference_id'          => $project_id,
            'reference_column'      => 'project_id',
            'reference_table'       => 'fs_projects',
            'mail_flag'             => 'N',
            'is_sent_flag'          => 'N',
            'timeline_flag'         => 'Y',
            'mail_recipient'        => ''
        ];
        $m_activity_logs->insert_log($activity_log_params);

        $po_lines_arr = [];
        $po_approver_params = [];
        $delivery_sched_params = [];
        // insert po lines

        $email_data = [];

        foreach($requirement_lines as $vehicle_type => $models){
            
            $approvers = $m_approver->get_po_approvers($vehicle_type);
            foreach($approvers as $approver){
                $temp = [
                    'module_id'           => 2, // purchase order
                    'module_reference_id' => $po_header_id,
                    'approver_id'         => $approver->approver_id,
                    'hierarchy'           => $approver->hierarchy,
                    'status'              => 7, // pending
                    'column_reference'    => 'po_header_id',
                    'table_reference'     => 'fs_po_headers',
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                ];
                array_push($po_approver_params, $temp);

                $temp_email = [
                    'module_id'             => 1, // Fleet Project
                    'module_code'           => 'PRJ',
                    'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has submitted a purchase order for Project No. <strong>' . $project_id . '</strong>',
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                    'reference_id'          => $project_id,
                    'reference_column'      => 'project_id',
                    'reference_table'       => 'fs_projects',
                    'mail_flag'             => 'Y',
                    'is_sent_flag'          => 'N',
                    'timeline_flag'         => 'N',
                    'mail_recipient'        => $approver->email_address
                ];
                array_push($email_data, $temp_email);
            }

            foreach ($models as $model) {
                $po_line_arr = [
                    'po_header_id'          => $po_header_id,
                    'requirement_line_id'   => $model['requirement_line_id'],
                    'po_quantity'           => $model['po_qty'],
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                ];
                $po_line_id = $m_po_lines->insert_po_lines($po_line_arr);
                //array_push($po_lines_arr, $temp_arr);
            
                foreach($model['delivery_sched'] as $sched){
                    $sched_params = [
                        'requirement_line_id'   => $model['requirement_line_id'],
                        'quantity'              => $sched['quantity'],
                        'delivery_date'         => $sched['delivery_date'],
                        'module_id'             => 2, // purchase order module
                        'owner_id'              => $sched['owner_id'],
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id'],
                        'po_line_id'            => $po_line_id
                    ];
                    array_push($delivery_sched_params, $sched_params);
                    
                    /*if($sched['owner_id'] == 6 && in_array(session('user')['user_type_id'], array(27,31)) ){
                        array_push($delivery_sched_params, $sched_params);
                    }
                    else if($sched['owner_id'] == 5 && in_array(session('user')['user_type_id'], array(32,33)) ){
                        array_push($delivery_sched_params, $sched_params);
                    }*/
                    
                    
                }
            }
        }

        // insert po lines
        //$m_po_lines->insert_po_lines($po_lines_arr);
        // insert delivery schedule
        $m_delivery_sched->insert_delivery_schedule($delivery_sched_params);
        // insert po approval
        $m_approval->insert_module_approval($po_approver_params);
        // insert activity logs for email
        $m_activity_logs->insert_log($email_data);

        return [
            'status' => 'success',
            'po_header_id' => $po_header_id
        ];
    }

    public function upload_po_attachment(Request $request, Attachment $m_attachment){
        $attachment        = $request->file('attachments');
        $po_header_id      = $request->po_header_id;
        $attachment_params = [];
        $file_index        = 0;

        if(!empty($_FILES)){

            if(!empty($attachment)){
                foreach($attachment as $file){
                    //Move Uploaded File
                    $filename = Carbon::now()->timestamp . $file_index . '.' . $file->getClientOriginalExtension();
                    $actual_directory = Storage::putFileAs(
                        'public/po', $file, $filename
                    );
                    $orig_filename = $file->getClientOriginalName();
                    $temp = [
                        'filename'              => $filename,
                        'directory'             => $actual_directory,
                        'module_id'             => 1, // Fleet project
                        'reference_id'          => $po_header_id,
                        'reference_table'       => 'fs_po_headers',
                        'reference_column'      => 'po_header_id',
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id'],
                        'orig_filename'         => $orig_filename,
                        'owner_id'              => 4, // purchase order as owner of the file
                        'symlink_dir'           => 'public/storage/po/'
                    ];         
                    array_push($attachment_params,$temp);
                    $file_index++;
                }
            }
            $m_attachment->insert_attachment($attachment_params);
        }
        return response()->json(
            [
                'status'     => "success",
                'project_id' => $po_header_id
            ]
        );
    }

    public function save_po_validation(
        Request $request, 
        ModuleApproval $m_approval, 
        POHeaders $m_poh,
        Project $m_project,
        ActivityLogs $m_activity_logs
    ){
        $po_header_id = $request->po_header_id;
        $approval_id = $request->approval_id;
        $remarks = $request->remarks;
        $status  = $request->status;
        $project_id = $request->project_id;
        $project_details = $m_project->get_details($project_id);
        $status_id = 0;

        if($status == "approve"){
            $status_id = 4; // approve
        }
        else if($status == "reject") {
            $status_id = 5; // reject
            // once rejected by an approver, reject whole PO submission
            $m_poh->update_status(
                $po_header_id,
                $status_id, ///acknowledge
                session('user')['user_id'],
                session('user')['source_id']
            );

        }

        $m_approval->save_approval(
            $approval_id, 
            $po_header_id, // module_reference_id, 
            'fs_po_headers', 
            'po_header_id', 
            $status_id, 
            $remarks,
            session('user')['user_id'],
            session('user')['source_id']
        ); 

        $activity_log = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has approved purchase order no. <strong>'.$po_header_id.'</strong>',
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'reference_id'          => $project_id,
            'reference_column'      => 'project_id',
            'reference_table'       => 'fs_projects',
            'mail_flag'             => 'Y',
            'is_sent_flag'          => 'N',
            'timeline_flag'         => 'Y',
            'mail_recipient'        => $project_details->requestor_email
        ];
        $m_activity_logs->insert_log($activity_log);

        $pending = $m_approval->get_pending_per_po($po_header_id);

        // if no more approvals are pending
        if($pending == 0){
            $m_poh->update_status(
                $po_header_id,
                $status_id, ///approve or reject
                session('user')['user_id'],
                session('user')['source_id']
            );

            $activity_log = [
                'module_id'             => 1, // Fleet Project
                'module_code'           => 'PRJ',
                'content'               => 'Purchase Order No. <strong>'.$po_header_id.'</strong> has been <strong>acknowledged</strong>.',
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'reference_id'          => $project_id,
                'reference_column'      => 'project_id',
                'reference_table'       => 'fs_projects',
                'mail_flag'             => 'Y',
                'is_sent_flag'          => 'N',
                'timeline_flag'         => 'Y',
                'mail_recipient'        =>  $project_details->requestor_email
            ];
            $m_activity_logs->insert_log($activity_log);

        }
    }

    public function get_filtered_po(Request $m_request, POHeaders $m_poh){
        $customer_id = $m_request->customer_id;
        $start_date  = $m_request->start_date;
        $end_date    = $m_request->end_date;
        $dealer      = $m_request->dealer;
        $status      = $m_request->status;
     
        $po = $m_poh->get_filtered_po(
            session('user')['user_type_id'],
            $dealer,
            $start_date,
            $end_date,
            $customer_id,
            $status
        );

        return $po;

    }
}
