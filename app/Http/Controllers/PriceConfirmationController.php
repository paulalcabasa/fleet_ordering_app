<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Models\Customer;
use App\Models\VehicleType;
use App\Models\Project;
use App\Models\FPC;
use App\Models\FPC_Project;
use App\Models\FPC_Item;
use App\Models\Competitor;
use App\Helpers\VehicleTypeIdentification;
use App\Helpers\FPCHelper;
use App\Models\PaymentTerms;
use App\Models\FPCItemFreebies;
use App\Models\Attachment;
use App\Models\SalesPersonsOra;
use App\Models\FleetCategories;
use PDF;
use App\Models\Approver;
use App\Models\ProjectDeliverySchedule;
use App\Models\ActivityLogs;

class PriceConfirmationController extends Controller
{   

    protected $vehicle_type;

    public function __construct(VehicleTypeIdentification $vehicle_type){
        $this->vehicle_type = $vehicle_type;
    }

    public function all_price_confirmation(FPC $m_fpc){
        $user_type_id = session('user')['user_type_id'];

        if(in_array($user_type_id, array(32,33))){
            $fpc_list = $m_fpc->get_fpc(
                $this->vehicle_type->get_vehicle_type($user_type_id)
            );

            $page_data = [
                'fpc_list' => $fpc_list,
                'base_url' => url('/')
            ];
        	return view('price_confirmation.all_price_confirmation', $page_data);
        }
  /*      else if(in_array($user_type_id, array(27))){
            $fpc_list = $m_fpc->get_fpc_dealer(session('user')['customer_id']);
            $page_data = [
                'fpc_list' => $fpc_list,
                'base_url' => url('/')
            ];
            return view('price_confirmation.dealer_fpc_list', $page_data);
        }*/
    }

    public function price_confirmation_entry(Customer $m_customer){   
        $customers = $m_customer->get_project_customers(
            $this->vehicle_type->get_vehicle_type(session('user')['user_type_id'])
        );
        $page_data = [
            'customers'    => $customers,
            'base_url'     => url('/')
        ];
    	return view('price_confirmation.price_confirmation_entry', $page_data);
    }

    public function price_confirmation_details(
        Request $request,
        FPC $m_fpc,
        Customer $m_customer,
        FPC_Project $m_fpc_project,
        FPC_Item $m_fpc_item,
        Competitor $m_competitor,
        PaymentTerms $m_payment_terms,
        FPCHelper $fpc_helper,
        Attachment $m_attachment
    ){

    	$price_confirmation_id = $request->price_confirmation_id;
    	$action                = $request->action;
        $fpc_details      = $m_fpc->get_details($price_confirmation_id);
        $editable         = $fpc_helper->editable($fpc_details->status_name);
        $customer_details = $m_customer->get_customer_details_by_id($fpc_details->customer_id);
        $project_headers  = $m_fpc_project->get_projects($price_confirmation_id);
        $fpc_attachments  = $m_attachment->get_fpc_attachments($price_confirmation_id);
        $projects         = [];

        foreach($project_headers as $project){

            $requirements = $m_fpc_item->get_item_requirements($project->fpc_project_id);
            $competitors = $m_competitor->get_competitors($project->project_id);
            $competitor_attachments = $m_attachment->get_competitor_attachments($project->project_id);
            $temp_arr = [
                'project_id'             => $project->project_id,
                'payment_terms'          => $project->payment_terms,
                'validity'               => $project->validity,
                'availability'           => $project->availability,
                'note'                   => $project->note,
                'dealer_name'            => $project->dealer_name,
                'dealer_account'         => $project->dealer_account,
                'project_status'         => $project->project_status,
                'fpc_project_id'         => $project->fpc_project_id,
                'requirements'           => $requirements,
                'competitors'            => $competitors,
                'competitor_attachments' => $competitor_attachments,
                'term_name'              => $project->term_name,
                'validity_disp'          => $project->validity_disp,
                'competitor_flag'        => $project->competitor_flag,
                'competitor_remarks'     => $project->competitor_remarks
            ];
            array_push($projects,$temp_arr);
        }

        $payment_terms = $m_payment_terms->get_payment_terms();
    
    	$page_data = array(
    		'price_confirmation_id' => $price_confirmation_id,
            'action'           => $action,
            'fpc_details'      => $fpc_details,
            'customer_details' => $customer_details,
            'projects'         => $projects,
            'payment_terms'    => $payment_terms,
            'base_url'         => url('/'),
            'editable'         => $editable,
            'fpc_attachments'  => $fpc_attachments
    	);
    	return view('price_confirmation.price_confirmation_details', $page_data);
    }

    public function manage_fwpc(Request $request){
        $price_confirmation_id = $request->price_confirmation_id;
        $action = $request->action;
        $page_data = array(
            'price_confirmation_id' => $price_confirmation_id,
            'action' => $action
        );
        return view('price_confirmation.manage_fwpc',$page_data); 
    }

    public function all_fwpc(Request $request){
        return view('price_confirmation.all_fwpc'); 
    }

    public function view_fpc(Request $request){
        $price_confirmation_id = $request->price_confirmation_id;
        $page_data = array(
            'price_confirmation_id' => $request->price_confirmation_id
        );
        return view('price_confirmation.view_fpc',$page_data); 
    }

    public function fpc_approval(){
        return view('price_confirmation.fpc_approval'); 
    }

    public function fpc_details(Request $request){
        $page_data = array(
            'action' => $request->action,
            'fpc_id' => $request->fpc_id
        );
        return view('price_confirmation.fpc_details', $page_data);
    }

    public function ajax_get_projects(Request $request, Project $m_project){
        $customer_id = $request->customer_id;
        $vehicle_type = $this->vehicle_type->get_vehicle_type(session('user')['user_type_id']);
        $projects = $m_project->get_projects_for_fpc($customer_id,$vehicle_type);
        return $projects;
    }

    public function save_fpc(
        Request $request,
        FPC $m_fpc,
        FPC_Project $m_fpc_project,
        FPC_Item $m_fpc_item
    ){
        $customer_id = $request['customerDetails']['customerId'];
        
        $projects = $request['projects'];
        
        $vehicle_type = $this->vehicle_type->get_vehicle_type(session('user')['user_type_id']);

        // insert FPC Header
        $fpc_params = [
            'customer_id'           => $customer_id,
            'vehicle_type'          => $vehicle_type,
            'status'                => 12, // in progress
            'created_by'            => session('user')['user_id'],
            'create_user_source_id' => session('user')['source_id'],
            'creation_date'         => Carbon::now()
        ];
        $fpc_id = $m_fpc->insert_fpc($fpc_params);
        // end of FPC header

        // insert fpc projects
        $project_params = [];

        foreach($projects as $project){
            $temp_arr = [
                'fpc_id'                => $fpc_id,
                'project_id'            => $project['project_id'],
                'requirement_header_id' => $project['requirement_header_id'],
                'status'                => 12, // in progress
                'created_by'            => session('user')['user_id'],
                'create_user_source_id' => session('user')['source_id'],
                'creation_date'         => Carbon::now()
            ];
            array_push($project_params,$temp_arr);
        }
        $m_fpc_project->insert_fpc_project($project_params);
        // end of FPC projects

        // insert fpc project items
        $requirements = $m_fpc_item->get_fpc_item_requirements($fpc_id);
        $item_params = [];
        foreach($requirements as $item){
            $arr = [
                'fpc_project_id'         => $item->fpc_project_id,
                'requirement_line_id'    => $item->requirement_line_id,
                'suggested_retail_price' => $item->price,
                'wholesale_price'        => $item->price,
                'fleet_price'            => $item->price,
                'dealers_margin'         => 6, // default to 6 but should be from lookup,
                'lto_registration'       => 10500, // default to 10500 but should be from lookup
                'created_by'             => session('user')['user_id'],
                'create_user_source_id'  => session('user')['source_id'],
                'creation_date'          => Carbon::now()
            ];
            array_push($item_params,$arr);
        }

        $m_fpc_item->insert_fpc_item($item_params);
        // end of fpc project items
        return [
            'customer_id' => $customer_id,
            'projects'    => $projects,
            'fpc_id'      => $fpc_id 
        ];
    }

    public function ajax_get_freebies(Request $request, FPCItemFreebies $m_freebies){
        $fpc_item_id = $request->fpc_item_id;
        $freebies = $m_freebies->get_item_freebies($fpc_item_id);
        return $freebies;
    }

    public function ajax_save_fpc_item(Request $request, FPC_Item $m_fpc_item, FPCItemFreebies $m_freebies){
        $model_data = $request->modelData;
        $freebies = $request->freebies;

        $del_freebie = [];
        $add_freebie = [];
        foreach($freebies as $freebie){
            if(isset($freebie['deleted'])){
                $m_freebies->delete_freebie($freebie['freebie_id']);        
            }
            else {
                $m_freebies->create_freebies(
                    $freebie['fpc_item_id'],
                    $freebie['description'], 
                    $freebie['amount'], 
                    session('user')['user_id'],
                    session('user')['source_id'],
                    Carbon::now()
                );
            }
        }

        $m_fpc_item->updateFPCItem(
            $model_data['dealers_margin'], 
            $model_data['lto_registration'], 
            $model_data['fleet_price'],
            session('user')['user_id'],
            session('user')['source_id'], 
            $model_data['fpc_item_id']
        );

        return [
            'model' => $model_data,
            'test' => $model_data['fpc_item_id'],
            'freebies' => $freebies
        ];
    }

    public function ajax_save_terms(Request $request, FPC_Project $m_fpc_project){
        $fpc_project_id = $request->fpc_project_id;
        $payment_terms  = $request->payment_terms;
        $validity       = $request->validity;
        $availability   = $request->availability;
        $note           = $request->note;

        $m_fpc_project->update_fpc_project(
            $fpc_project_id, 
            $payment_terms,
            $validity,
            $availability,
            $note,
            session('user')['user_id'],
            session('user')['source_id']
        );
    }

    public function ajax_approve_fpc(
        Request $request, 
        Attachment $m_attachment, 
        FPC $m_fpc, 
        FPCHelper $fpc_helper,
        ActivityLogs $m_activity_logs,
        FPC_Project $m_fpc_project
    ){
        $attachment        = $request->fpc_attachment;
        $fpc_id            = $request->fpc_id;
        $remarks           = $request->remarks;
        $attachment_params = [];
        $file_index        = 0;
        //$destinationPath   = 'storage/app/attachments';
        
        // approve fpc
        $m_fpc->update_status(
            $fpc_id, 
            $remarks, 
            session('user')['user_id'],
            session('user')['source_id'],
            4 // approved
        );

        $fpc_projects = $m_fpc_project->get_projects($fpc_id);
        foreach($fpc_projects as $row){
            /* activity logs */
            $activity_log_params = [
                'module_id'             => 1, // Fleet Project
                'module_code'           => 'PRJ',
                'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has created an FPC for Project No. <strong>'. $row->project_id .'</strong>',
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'reference_id'          => $row->project_id,
                'reference_column'      => 'project_id',
                'reference_table'       => 'fs_projects',
                'mail_flag'             => 'Y',
                'is_sent_flag'          => 'N',
                'timeline_flag'         => 'Y',
                'mail_recipient'        => $row->requestor_email
            ];
            $m_activity_logs->insert_log($activity_log_params);
        }
    
        if(!empty($_FILES)){
            if(!empty($attachment)){
                foreach($attachment as $file){
                    //Move Uploaded File
                    $filename = Carbon::now()->timestamp . $file_index . '.' . $file->getClientOriginalExtension();
                    $orig_filename = $file->getClientOriginalName();

                    $fpcPath = Storage::putFileAs(
                        'public/fpc', $file, $filename
                    );  

                    $temp = [
                        'filename'              => $filename,
                        'directory'             => $fpcPath,
                        'module_id'             => 3, // Fleet Price Confirmation
                        'reference_id'          => $fpc_id,
                        'reference_table'       => 'fs_fpc',
                        'reference_column'      => 'fpc_id',
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id'],
                        'orig_filename'         => $orig_filename,
                        'owner_id'              => 3, // customer as owner
                        'symlink_dir'           => 'public/storage/fpc/'
                    ];         
                    array_push($attachment_params,$temp);
                   // $file->move($destinationPath,$filename);
                    $file_index++;
                }

                $m_attachment->insert_attachment($attachment_params);
            }
        }
 
        $editable = $fpc_helper->editable('Approved');

        return [
            'status' => "Approved",
            'editable' => $editable
        ];

    }

    public function ajax_cancel_fpc(Request $request, FPC $m_fpc, FPCHelper $fpc_helper){
        $fpc_id = $request->fpc_id;
        $m_fpc->update_status(
            $fpc_id, 
            null, // remarks 
            session('user')['user_id'],
            session('user')['source_id'],
            6 // cancelled
        );

        $editable = $fpc_helper->editable('Cancelled');

        return [
            'status' => "Cancelled",
            'editable' => $editable
        ];

    }

    public function print_fpc(
        Request $request,
        FPC_Project $m_fpc_project,
        SalesPersonsOra $m_sales_persons,
        FPC_Item $m_fpc_item,
        Approver $m_approver

    ){
        $fpc_project_id = $request->fpc_project_id;
        $header_data = $m_fpc_project->get_fpc_project_details($fpc_project_id);
        $sales_persons = $m_sales_persons->get_sales_persons($header_data->project_id);
        $items = $m_fpc_item->get_item_requirements($fpc_project_id);
        $signatories = $m_approver->get_fpc_signatories($header_data->vehicle_type);
        $signatories = collect($signatories)->groupBy('user_type');

    
        $data = [
            'header_data'   => $header_data,
            'sales_persons' => $sales_persons,
            'items'         => $items,
            'signatories'   => $signatories
        ];

        $pdf = PDF::loadView('pdf.print_fpc', $data);
        return $pdf->setPaper('a4','portrait')->stream();
    }

    public function fpc_overview(
        Request $request,
        Project $m_project,
        FPC $m_fpc,
        FPC_Item $m_fpc_item,
        Attachment $m_attachment
    ){
        $project_id      = $request->project_id;
        $project_details = $m_project->get_details($project_id);

        $fpc_headers = $m_fpc->get_fpc_by_project($project_id);
        
        $fpc_data = [];

        $vehicle_colors = config('app.vehicle_badge_colors');
        $status_colors = config('app.status_colors');

        foreach($fpc_headers as $fpc){
            $items = $m_fpc_item->get_item_requirements($fpc->fpc_project_id);
            $attachments  = $m_attachment->get_fpc_attachments($fpc->fpc_id);
            $temp_array = [
                'fpc_header' => $fpc,
                'fpc_lines'  => $items,
                'attachments' => $attachments
            ];
            array_push($fpc_data,$temp_array);
        }


        $page_data = [
            'project_details' => $project_details,
            'fpc_data'        => $fpc_data,
            'base_url'        => url('/'),
            'vehicle_colors'  => $vehicle_colors,
            'status_colors'   => $status_colors
        ];

        return view('price_confirmation.fpc_overview', $page_data); 
    }

    public function ajax_get_fpc_details(
        Request $request,
        FPCItemFreebies $m_freebies,
        ProjectDeliverySchedule $m_delivery_sched
    ){

        $fpc_item_id = $request->fpc_item_id;
        $freebies = $m_freebies->get_item_freebies($fpc_item_id);

        $requirement_line_id = $request->requirement_line_id;
        $delivery_sched = $m_delivery_sched->get_delivery_schedule($requirement_line_id);

        return [
            'freebies' => $freebies,
            'delivery_sched' => $delivery_sched
        ];
    }

    public function print_fpc_dealer(
        Request $request,
        Project $m_project,
        FPC_Project $m_fpc_project,
        SalesPersonsOra $m_sales_persons,
        FPC_Item $m_fpc_item,
        Approver $m_approver,
        FPC $m_fpc

    ){
        $project_id = $request->project_id;
        $print_type = $request->print_type;
        $project_details = $m_project->get_details($project_id);

        if($print_type == "single"){
            $fpc_headers = $m_fpc->get_fpc_by_id($request->fpc_id);
        }
        else if($print_type == "multiple"){
            $fpc_headers = $m_fpc->get_fpc_by_project($project_id);
        }
        $fpc_data = [];
        foreach($fpc_headers as $fpc){
            $items = $m_fpc_item->get_item_requirements($fpc->fpc_project_id);
            $temp_array = [
                'fpc_header' => $fpc,
                'fpc_lines'  => $items
            ];
            array_push($fpc_data,$temp_array);
        }
        $data = [
            'project_details' => $project_details,
            'fpc_data'        => $fpc_data,
        ];

        $pdf = PDF::loadView('pdf.print_fpc_dealer', $data);
        return $pdf->setPaper('a4','portrait')->stream();
    }
}
