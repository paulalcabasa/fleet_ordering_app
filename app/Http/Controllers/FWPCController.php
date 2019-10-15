<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;
use App\Models\FWPC;
use App\Models\SalesOrderLines;
use App\Models\FPC_Project;
use Carbon\Carbon;
use App\Models\SalesPersonsOra;
use App\Models\ActivityLogs;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use App\Models\Attachment;
use App\Models\Approver;
use App\Models\Dealer;

class FWPCController extends Controller
{
    public function add_fwpc(
        Request $request, 
        FWPC $m_fwpc,
        ActivityLogs $m_activity_logs,
        Project $m_project
    ){
        $params = [
            'project_id'            => $request->project_id,
            'sales_order_header_id' => $request->sales_order_id,
            'fpc_project_id'        => $request->fpc_project_id, 
            'po_header_id'          => $request->po_header_id,
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'status'                => 3 // new
        ];
        $fwpc_id         = $m_fwpc->insert_fwpc($params);
        $data            = $m_fwpc->get_fwpc_by_id($fwpc_id);
        $project_details = $m_project->get_details($request->project_id);

        $activity_log = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has created an FPWC for Project No. <strong>'.$request->project_id.'</strong>.',
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'reference_id'          => $request->project_id,
            'reference_column'      => 'project_id',
            'reference_table'       => 'fs_projects',
            'mail_flag'             => 'Y',
            'is_sent_flag'          => 'N',
            'timeline_flag'         => 'Y',
            'mail_recipient'        => $project_details->requestor_email
        ];
        $m_activity_logs->insert_log($activity_log);
        return response()->json($data);
    }

    public function get_fwpc_list(Request $request){
        return response()->json($m_fwpc->get_fwpc_by_project($request->project_id));
    }

    public function delete_fwpc(
        Request $request, 
        FWPC $m_fwpc,
        ActivityLogs $m_activity_logs
    ){
        $fwpc_id      = $request->fwpc_id;
        $data         = $m_fwpc->get_fwpc_by_id($fwpc_id);
        $query        = $m_fwpc->delete_fwpc($fwpc_id);
        $activity_log = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has deleted FPWC No. <strong>'. $fwpc_id .'</strong> with Sales Order No. <strong>'. $data->order_number.'</strong> for Project No. <strong>'.$data->project_id.'</strong>.',
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'reference_id'          => $data->project_id,
            'reference_column'      => 'project_id',
            'reference_table'       => 'fs_projects',
            'mail_flag'             => 'N',
            'is_sent_flag'          => 'N',
            'timeline_flag'         => 'Y',
            'mail_recipient'        => ''
        ];
        $m_activity_logs->insert_log($activity_log);
        return $query;
    }

    public function print_fwpc(
        Request $request,
        FWPC $m_fwpc,
        FPC_Project $m_fpc_project,
        SalesPersonsOra $m_sales_persons,
        SalesOrderLines $m_sol
    ){
        $fwpc_id = $request->fwpc_id;
        $fwpc_details = $m_fwpc->get_fwpc_by_id($fwpc_id);
        $sales_persons = $m_sales_persons->get_sales_persons($fwpc_details->project_id);
        
        $so_lines = $m_sol->get_so_lines($fwpc_id);
        
        
        $wht_tax = 0;
        $grand_total = 0;
        foreach($so_lines as $row){
            $dealers_margin = $row->fleet_price * ($row->dealers_margin/100);
            $total_margin   = $dealers_margin + $row->lto_registration;
            $unit_price     = $row->fleet_price - $total_margin;
            $fwpu           = $unit_price + $row->freebies;
            $total_fwpu     = $fwpu * $row->quantity;
            $grand_total    += $total_fwpu;
        }

        $wht_tax = ($grand_total / 1.12) * 0.01;
        $check_amount = $grand_total - $wht_tax;
        $data = [
            'fwpc_details'  => $fwpc_details,
            'sales_persons' => $sales_persons,
            'so_lines'      => $so_lines,
            'wht_tax'       => $wht_tax,
            'check_amount'  => $check_amount
        ];


        $pdf = PDF::loadView('pdf.print_fwpc', $data);
        return $pdf->setPaper('a4','portrait')->stream();

    }    

    public function upload_fwpc_doc(
        Request $request,
        Attachment $m_attachment,
        ActivityLogs $m_activity_logs,
        FWPC $m_fwpc,
        Approver $m_approver
    ){
        $file = $request->file('file');
        $fwpc_id = $request->fwpc_id;
        $fwpc_details = $m_fwpc->get_fwpc_by_id($fwpc_id);
        $owner_id = $request->owner_id;
        $user_type = session('user')['user_type_id'];
        //if(in_array($user_type,array(27,31))) {
       //     $owner_id = 6;
       // }
        /*if(in_array($user_type,array(27,31))) { // 'Dealer Staff','Dealer Manager'
            $owner_id = 6;
            $email_data = [];
            // send notification to approvers
            $approvers = $m_approver->get_po_approvers($fwpc_details->vehicle_type);
            foreach($approvers as $approver){   
                $temp_email = [
                    'module_id'             => 1, // Fleet Project
                    'module_code'           => 'PRJ',
                    'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has uploaded a signed FPWC Document for FPWC No. <strong>'. $fwpc_details->fwpc_id .'</strong> with Sales Order No. <strong>'. $fwpc_details->order_number.'</strong> for Project No. <strong>'.$fwpc_details->project_id.'</strong>.',
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                    'created_by'            => session('user')['user_id'],
                    'reference_id'          => $fwpc_details->project_id,
                    'reference_column'      => 'project_id',
                    'reference_table'       => 'fs_projects',
                    'mail_flag'             => 'Y',
                    'is_sent_flag'          => 'N',
                    'timeline_flag'         => 'Y',
                    'mail_recipient'        => $approver->email_address
                ];
                array_push($email_data, $temp_email);
            }
            
            // insert activity logs for email
            $m_activity_logs->insert_log($email_data);
        }
        */
        //else if(in_array($user_type,array(32,33))) { //  Fleet LCV User
            //$owner_id = 5;
            // send notification to Requestor
            // activity log insertion
            /*$activity_log = [
                'module_id'             => 1, // Fleet Project
                'module_code'           => 'PRJ',
                'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has uploaded a signed FPWC Document for FPWC No. <strong>'. $fwpc_details->fwpc_id .'</strong> with Sales Order No. <strong>'. $fwpc_details->order_number.'</strong> for Project No. <strong>'.$fwpc_details->project_id.'</strong>.',
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'reference_id'          => $fwpc_details->project_id,
                'reference_column'      => 'project_id',
                'reference_table'       => 'fs_projects',
                'mail_flag'             => 'Y',
                'is_sent_flag'          => 'N',
                'timeline_flag'         => 'Y',
                'mail_recipient'        => $fwpc_details->email_address
            ];
            $m_activity_logs->insert_log($activity_log);
            */
            // end of activity log
        //}

        // delete previous file before uploading new
        $previous_files = $m_attachment->get_fwpc_attachments($fwpc_id, $owner_id);
        foreach($previous_files as $row){
            Storage::delete($row->directory);  
            $m_attachment->delete_fwpc_attachment($row->reference_id, $row->owner_id);
        }
        // end of file deletion

        // file upload
        $filename = Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
        $actual_directory = Storage::putFileAs(
            'public/fwpc', $file, $filename
        );
        $orig_filename = $file->getClientOriginalName();
        $file_params = [
            'filename'              => $filename,
            'directory'             => $actual_directory,
            'module_id'             => 1, // Fleet project
            'reference_id'          => $fwpc_id,
            'reference_table'       => 'fs_fwpc',
            'reference_column'      => 'fwpc_id',
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'orig_filename'         => $orig_filename,
            'owner_id'              => $owner_id, // dealer as owners of the file
            'symlink_dir'           => 'public/storage/fwpc/'
        ];         
        $m_attachment->insert_attachment($file_params);
        // end of file upload 
        // update status
        $m_fwpc->update_fwpc_status(
            $fwpc_id, 
            '', 
            7, // pending status 
            session('user')['user_id'], 
            session('user')['source_id']
        );
        
    }

    public function validate_fwpc(
        Request $request,
        FWPC $m_fwpc,
        ActivityLogs $m_activity_logs
    ){
        $fwpc_id      = $request->fwpc_id;
        $status       = $request->status;
        $remarks      = $request->remarks;
        $fwpc_details = $m_fwpc->get_fwpc_by_id($fwpc_id);
        // update FWPC status
        $status_id = 0;
        $message = "";
        if($status == "approve") {
            $status_id = 4;
            $message = session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has approved FPWC No. <strong>'.$fwpc_id.'</strong>.';

        }
        else if($status == "reject"){
            $status_id = 5;
            $message = session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has rejected FPWC No. <strong>'.$fwpc_id.'</strong>.';
        }

        if($remarks != ""){
            $message .= '<br/>Remarks : <i>' . $remarks . '</i>';
        }

        $m_fwpc->update_fwpc_status(
            $fwpc_id, 
            $remarks, 
            $status_id, 
            session('user')['user_id'], 
            session('user')['source_id']
        );
        // end of updating of FWPC status

        // activity log insertion
        $activity_log = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => $message,
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'reference_id'          => $fwpc_details->project_id,
            'reference_column'      => 'project_id',
            'reference_table'       => 'fs_projects',
            'mail_flag'             => 'Y',
            'is_sent_flag'          => 'N',
            'timeline_flag'         => 'Y',
            'mail_recipient'        => $fwpc_details->email_address
        ];
        $m_activity_logs->insert_log($activity_log);
        // end of activity log
    }

    public function fwpc_list(FWPC $m_fwpc){
       
        if(in_array(session('user')['user_type_id'], array(32,33)) ){
            $dealers = Dealer::all();
        }
        else {
            $dealers = Dealer::find(session('user')['customer_id']);
        }

        $page_data = [
            'dealers'       => $dealers,
            'status_colors' => config('app.status_colors'),
            'user_type'     => session('user')['user_type_id'],
            'customer_id'   => session('user')['customer_id'] == null ? "" : session('user')['customer_id']
        ];

        
        return view('price_confirmation.fwpc_list', $page_data);
    }

    public function get_all_fwpc(FWPC $m_fwpc, Request $request){
        $start_date      = $request->start_date;
        $end_date        = $request->end_date;
        $fwpc_status     = $request->fwpc_status;
        $uninvoiced_flag = $request->uninvoiced_flag;
        $customer_id     = $request->customer_id;
        $dealer          = $request->dealer;
        $user_type_id    = session('user')['user_type_id'];

        $fwpc_list = $m_fwpc->get_fwpc_list(
            $user_type_id,
            $start_date,
            $end_date,
            $fwpc_status,
            $uninvoiced_flag,
            $customer_id,
            $dealer
        );


        return $fwpc_list;
    }
}
