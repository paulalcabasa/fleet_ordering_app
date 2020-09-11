<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use PDF;
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
use App\Models\Approver;
use App\Models\ProjectDeliverySchedule;
use App\Models\ActivityLogs;
use App\Models\Dealer;
use App\Models\OracleUser;
use App\Models\PriceListHeader;
use App\Models\FPCValidityRequest;
use App\Models\ValueSetCategory;
use App\Models\ValueSetName;
use App\Models\ModuleApproval;
class PriceConfirmationController extends Controller
{   

    protected $vehicle_type;

    public function __construct(VehicleTypeIdentification $vehicle_type){
        $this->vehicle_type = $vehicle_type;
    }

    public function all_price_confirmation(FPC $m_fpc){
        $user_type_id = session('user')['user_type_id'];

        if(in_array(session('user')['user_type_id'], array(32,33)) ){
            $dealers = Dealer::all();
        }
        else {
            //$dealers = Dealer::find(session('user')['customer_id']);
            return view('errors.404');
        }
        
        $page_data = [
            'base_url'      => url('/'),
            'dealers'       => $dealers,
            'status_colors' => config('app.status_colors'),
            'user_type'     => session('user')['user_type_id'],
            'customer_id'   => session('user')['customer_id'] == null ? "" : session('user')['customer_id']
        ];
    	return view('price_confirmation.all_price_confirmation', $page_data);
       
    }

    public function price_confirmation_entry(Customer $m_customer){   
       
        if(!in_array(session('user')['user_type_id'], array(32,33)) ){
            return view('errors.404');
        }

        $customers = $m_customer->get_project_customers(
            $this->vehicle_type->get_vehicle_type(session('user')['user_type_id'])
        );

  
        $page_data = [
            'customers'    => $customers,
            'base_url'     => url('/'),
            'status_colors' => config('app.status_colors')
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
        Attachment $m_attachment,
        PriceListHeader $m_plh,
        Approver $m_approver
    ){

        if(!in_array(session('user')['user_type_id'], array(32,33)) ){
            return view('errors.404');
        }
    
    	$price_confirmation_id = $request->price_confirmation_id;
    	$action                = $request->action;
    	$fpc_details           = $m_fpc->get_details($price_confirmation_id);
    	$editable              = $fpc_helper->editable($fpc_details->status_name);
    	$customer_details      = $m_customer->get_customer_details_by_id($fpc_details->customer_id);
    	$project_headers       = $m_fpc_project->get_projects($price_confirmation_id);
    	$fpc_attachments       = $m_attachment->get_fpc_attachments($price_confirmation_id);
    	$projects              = [];
    	$pricelist_headers     = $m_plh->get_active_headers();
    	$projectsArr           = [];
        foreach($project_headers as $project){

            $requirements            = $m_fpc_item->get_item_requirements($project->fpc_project_id);
            $competitors             = $m_competitor->get_competitors($project->project_id);
            $competitor_attachments  = $m_attachment->get_competitor_attachments($project->project_id);
            $fpc_project_attachments = $m_attachment->get_fpc_project_attachments($project->fpc_project_id);
            $temp_arr                = [
                'project_id'              => $project->project_id,
                'payment_terms'           => $project->payment_terms,
                'validity'                => $project->validity,
                'availability'            => $project->availability,
                'note'                    => $project->note,
                'dealer_name'             => $project->dealer_name,
                'dealer_account'          => $project->dealer_account,
                'project_status'          => $project->project_status,
                'fpc_project_id'          => $project->fpc_project_id,
                'requirements'            => $requirements,
                'competitors'             => $competitors,
                'competitor_attachments'  => $competitor_attachments,
                'term_name'               => $project->term_name,
                'validity_disp'           => $project->validity_disp,
                'competitor_flag'         => $project->competitor_flag,
                'competitor_remarks'      => $project->competitor_remarks,
                'fpc_project_attachments' => $fpc_project_attachments,
                'fpc_prj_status' => $project->fpc_prj_status
                
            ];
            array_push($projectsArr,$project->project_id);
            array_push($projects,$temp_arr);
        }
        $projectsArr = implode($projectsArr,',');
        $conflicts = $m_fpc->getConflictRequirements($projectsArr,$fpc_details->vehicle_type);
     
        $payment_terms = $m_payment_terms->get_payment_terms();
        $availability = ValueSetName::where('category_id', 1)->get();
        $note = ValueSetName::where('category_id', 2)->get();

        $approvers = $m_fpc->get_approvers($price_confirmation_id);
      
    	$page_data = array(
    		'price_confirmation_id' => $price_confirmation_id,
    		'action'                => $action,
    		'fpc_details'           => $fpc_details,
    		'customer_details'      => $customer_details,
    		'projects'              => $projects,
    		'payment_terms'         => $payment_terms,
    		'availability'          => $availability,
    		'note'                  => $note,
    		'base_url'              => url('/'),
    		'editable'              => $editable,
    		'fpc_attachments'       => $fpc_attachments,
    		'pricelist_headers'     => $pricelist_headers,
    		'status_colors'         => config('app.status_colors'),
    		'vehicle_lead_time'     => config('app.vehicle_lead_time'),
            'conflicts'             => $conflicts,
            'approvers'             => $approvers
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
        FPC_Item $m_fpc_item,
        Approver $m_approver
    ){
        $customer_id = $request['customerDetails']['customerId'];
        
        $projects = $request['projects'];
        
        $vehicle_type = $this->vehicle_type->get_vehicle_type(session('user')['user_type_id']);

        DB::beginTransaction();
        
        try {

          
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
            

            // approvers
            $approvers    = $m_approver->get_fpc_signatories($vehicle_type);
            $approval_params = [];
            $m_module_approval = new ModuleApproval;
            $hierarchy = 1;
            foreach($approvers as $row){
                $temp_arr = [
                    'module_id'             => 3, // Fleet Project
                    'module_reference_id'   => $fpc_id,
                    'approver_id'           => $row->approver_id,
                    'hierarchy'             => $hierarchy,
                    'status'                => 7, // Pending
                    'column_reference'      => 'fpc_id',
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                    'table_reference'       => 'fs_fpc'
                ];
                $hierarchy++;
                array_push($approval_params,$temp_arr);
            } 
            $m_module_approval->insert_module_approval($approval_params);
                
            // insert fpc projects
            $project_params = [];

            foreach($projects as $project){
                $project_params = [
                    'fpc_id'                => $fpc_id,
                    'project_id'            => $project['project_id'],
                    'requirement_header_id' => $project['requirement_header_id'],
                    'status'                => 12, // in progress
                    'created_by'            => session('user')['user_id'],
                    'create_user_source_id' => session('user')['source_id'],
                    'creation_date'         => Carbon::now()
                ];
                //array_push($project_params,$temp_arr);
                $fpc_project_id = $m_fpc_project->insert_fpc_project($project_params);
                $requirements = $m_fpc_item->get_fpc_item_requirements($fpc_project_id);
                $item_params = [];
                foreach($requirements as $item){
                    $arr = [
                        'fpc_project_id'         => $item->fpc_project_id,
                        'requirement_line_id'    => $item->requirement_line_id,
                        'suggested_retail_price' => 0, //$item->price,
                        'wholesale_price'        => 0, //$item->price,
                        'fleet_price'            => 0, //$item->price,
                        'dealers_margin'         => 0, // default to 6 but should be from lookup,
                        'lto_registration'       => 0, // default to 10500 but should be from lookup
                        'created_by'             => session('user')['user_id'],
                        'create_user_source_id'  => session('user')['source_id'],
                        'creation_date'          => Carbon::now()
                    ];
                    array_push($item_params,$arr);
                }
                $m_fpc_item->insert_fpc_item($item_params);
                
            }

            DB::commit();
            return [
                'customer_id' => $customer_id,
                'projects'    => $projects,
                'fpc_id'      => $fpc_id 
            ];

        } catch(\Exception $e) {
            DB::rollBack();
            return $e;
        }

        
    }

    public function ajax_get_freebies(Request $request, FPCItemFreebies $m_freebies){
        $fpc_item_id = $request->fpc_item_id;
        $freebies = $m_freebies->get_item_freebies($fpc_item_id);
        return $freebies;
    }

    public function delete_freebie(Request $request, FPCItemFreebies $m_freebies){
        $m_freebies->delete_freebie($request->freebie_id);     
    }

    public function ajax_save_fpc_item(Request $request, FPC_Item $m_fpc_item, FPCItemFreebies $m_freebies){
        $model_data          = $request->modelData;
        $freebies            = $request->freebies;
        $pricelist_header_id = $request->pricelist_header_id;
        $pricelist_line_id   = $request->pricelist_line_id;
        $del_freebie         = [];
        $add_freebie         = [];
        foreach($freebies as $freebie){
            //if(isset($freebie['deleted'])){
           /*  if(isset($f $freebie['deleted'] == 'Y'){
                $m_freebies->delete_freebie($freebie['freebie_id']);        
            } */
            //}
            //else {
         ///   if(isset($freebie['freebie_id'])) {
                // update
          //  }
          //  else {
                // insert
                $m_freebies->create_freebies(
                    $freebie['freebie_id'],
                    $freebie['fpc_item_id'],
                    $freebie['description'], 
                    $freebie['amount'], 
                    $freebie['cost_to'], 
                    session('user')['user_id'],
                    session('user')['source_id'],
                    Carbon::now()
                );
          //  }
            
         //   }
        }
        
        $m_fpc_item->updateFPCItem(
            [
                'dealers_margin'         => $model_data['dealers_margin'],
                'lto_registration'       => $model_data['lto_registration'],
                'fleet_price'            => $model_data['fleet_price'],
                'wholesale_price'        => $model_data['wholesale_price'],
                'discount'               => $model_data['discount'],
                'suggested_retail_price' => $model_data['suggested_retail_price'],
                'promo'                  => $model_data['promo'],
                'promo_title'            => $model_data['promo_title'],
                'updated_by'             => session('user')['user_id'],
                'update_user_source_id'  => session('user')['source_id'],
                'fpc_item_id'            => $model_data['fpc_item_id'],
                'pricelist_header_id'    => $pricelist_header_id,
                'pricelist_line_id'      => $pricelist_line_id,
            ]
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
        $fpc_project_id    = $request->fpc_project_id;
        $action            = $request->action;
        $attachment_params = [];
        $file_index        = 0;
        //$destinationPath = 'storage/app/attachments';
        
        if($action == "approve"){
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

                    $reference_table = "";
                    $reference_column = "";
                    $reference_id = "";
                    $owner_id = 0;
                    $module_id = 0;

                    if($action == "approve"){
                        $reference_table = 'fs_fpc';
                        $reference_column = 'fpc_id';
                        $reference_id = $fpc_id;
                        $owner_id = 3;
                        $module_id = 3;
                    }
                    else if($action == "attach"){
                        $reference_table = 'fs_fpc_projects';
                        $reference_column = 'fpc_project_id';
                        $reference_id = $fpc_project_id;
                        $owner_id = 7;
                        $module_id = 5;
                    }

                    $temp = [
                        'filename'              => $filename,
                        'directory'             => $fpcPath,
                        'module_id'             => $module_id, // Fleet Price Confirmation
                        'reference_id'          => $reference_id,
                        'reference_table'       => $reference_table,
                        'reference_column'      => $reference_column,
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id'],
                        'orig_filename'         => $orig_filename,
                        'owner_id'              => $owner_id, // customer as owner
                        'symlink_dir'           => 'public/storage/fpc/'
                    ];         
                    array_push($attachment_params,$temp);
                   // $file->move($destinationPath,$filename);
                    $file_index++;
                }

                $m_attachment->insert_attachment($attachment_params);
            }
        }
        
        
        $status = "";
        if($action == "approve"){
            $editable = $fpc_helper->editable('Approved');
            $status = "Approved";
        }
        else {
            $editable = false;
            $status = "Updated";
        }

        return [
            'status' => $status,
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

        $m_fpc_project = new FPC_Project;
        $fpc_projects = $m_fpc_project->get_projects($fpc_id);
        foreach($fpc_projects as $row){
            $m_fpc_project->update_fpc_status(
                $row->fpc_project_id,
                6,
                session('user')['user_id'],
                session('user')['source_id']
            );
        }
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
        Approver $m_approver,
        FPCItemFreebies $m_freebies

    ){

       /*  if(!in_array(session('user')['user_type_id'], array(32,33)) ){
            return view('errors.404');
        } */

        $fpc_project_id = $request->fpc_project_id;
        $header_data    = $m_fpc_project->get_fpc_project_details($fpc_project_id);
        $sales_persons  = $m_sales_persons->get_sales_persons($header_data->project_id);
        $items          = $m_fpc_item->get_item_requirements($fpc_project_id);
        $signatories    = $m_approver->get_fpc_signatories($header_data->vehicle_type);
        $signatories    = collect($signatories)->groupBy('signatory_type');
        
      //  dd($signatories);
      
        $items_arr = [];
        foreach($items as $row){
            $arr = [
                'header' => $row,
                'other_items' => $m_freebies->get_item_freebies($row->fpc_item_id)
            ];

            array_push($items_arr, $arr);
        }
        
      
        $data = [
            'header_data'   => $header_data,
            'sales_persons' => $sales_persons,
            'items'         => $items_arr,
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


    public function get_filtered_fpc(Request $m_request, FPC $m_fpc){
        $customer_id  = $m_request->customer_id;
        $start_date   = $m_request->start_date;
        $end_date     = $m_request->end_date;
        $dealer       = $m_request->dealer;
        $status       = $m_request->status;
        $user_type_id = session('user')['user_type_id'];

        $fpc = $m_fpc->get_filtered_fpc(
            $user_type_id,
            $dealer,
            $start_date,
            $end_date,
            $customer_id,
            $status,
            $this->vehicle_type->get_vehicle_type($user_type_id)
        );

        return $fpc;

    }

    public function print_fpc_conflict(
        Request $request,
        FPC_Item $m_fpc_item,
        FPCHelper $fpc_helper,
        FPC_Project $m_fpc_project,
        SalesPersonsOra $m_sales_persons,
        Approver $m_approver,
        FPC $m_fpc,
        FPCItemFreebies $m_freebies,
        OracleUser $m_ora_user
    ){

        if(!in_array(session('user')['user_type_id'], array(32,33)) ){
            return view('errors.404');
        }
        
        $fpc_id = $request->fpc_id;
        $vehicle_type = "";
        

        $inventory_items = $m_fpc_item->get_items_by_fpc($fpc_id);
        $inventory_items = array_pluck($inventory_items, 'inventory_item_id');
        $common_items = $fpc_helper->getArrayCommonValues($inventory_items);
        
        if(!empty($common_items)){


            $user_details = $m_ora_user->get_user_details(
                session('user')['user_id'],            
                session('user')['source_id']            
            );
                
            $fpc_details = $m_fpc->get_details($fpc_id);
            $signatories = $m_approver->get_fpc_signatories($fpc_details->vehicle_type);
            $signatories = collect($signatories)->groupBy('signatory_type');
       
            $common_inventory_item_id = array_unique($common_items);

            $projects  = [];
            $attention = [];
            $terms     = [];

            $fpc_projects = $m_fpc_project->get_projects_with_conflict($fpc_id,$common_inventory_item_id);
            foreach ($fpc_projects as $project) {
                $header_data = $m_fpc_project->get_fpc_project_details($project->fpc_project_id);
                $sales_persons  = $m_sales_persons->get_sales_persons($header_data->project_id);
                array_push($projects, $header_data);
                array_push($attention, $sales_persons);
                array_push(
                    $terms,
                    [
                        $header_data->note,
                        $header_data->availability,
                        $header_data->validity,
                        $header_data->term_name,
                    ]
                );
            }

            $terms = array_unique($terms,SORT_REGULAR);
        
            $requirements = $m_fpc_item->get_conflict_item_requirement($fpc_id, $common_inventory_item_id);
            
            $detailed_price = $m_fpc_item->get_item_requirement_by_fpc_id($fpc_id,$common_inventory_item_id);
            $items_arr = [];

            foreach($detailed_price as $row){
                $arr = [
                    'header' => $row,
                    'other_items' => $m_freebies->get_item_freebies($row->fpc_item_id)
                ];

                array_push($items_arr, $arr);
            }

        
            $data = [
                'projects'       => $projects,
                'attention'      => $attention,
                'requirements'   => $requirements,
                'detailed_price' => $items_arr,
                'signatories'    => $signatories,
                'fpc_details'    => $fpc_details,
                'terms'          => $terms,
                'user_details'   => $user_details
            ];

     
            $pdf = PDF::loadView('pdf.print_fpc_conflict', $data);
            return $pdf->setPaper('a4','portrait')->stream();

        }
        else {
            return 'No conflicting models';
        }
        
    }

    public function cancelFPCProject(
        Request $request, 
        Project $m_project, 
        FPC_Project $m_fpc_project
    ){
        $project_id     = $request->project_id;
        // update project details
        /* $m_project->update_status(
            $project_id,
            6,
            session('user')['user_id'],            
            session('user')['source_id'] 
        ); */
        // update fpc project
        $fpc_project_id = $request->fpc_project_id;
        $m_fpc_project->update_fpc_status(
            $fpc_project_id, 
            6,
            session('user')['user_id'],            
            session('user')['source_id'] 
        );
    }

    public function save_fpc_extension(
        Request $request, 
        FPCValidityRequest $m_validity_request, 
        ActivityLogs $m_activity_logs,
        FPC_Project $m_fpc_project
    ){
        $validity_request = $request->validity_request;
     
        if($validity_request['action'] == "approve"){
            
            $m_validity_request->update_status(
                [
                    'request_id'            => $validity_request['request_id'],
                    'approved_date'         => $validity_request['approved_date'],
                    'status'                => 4,                                       // status
                    'approver_remarks'      => $validity_request['approver_remarks'],
                    'updated_by'            => session('user')['user_id'],
                    'update_user_source_id' => session('user')['source_id'],
                    'update_date'          => Carbon::now()
                ]
            );
            
            $m_fpc_project->update_validity(
                [
                    'fpc_project_id'        => $validity_request['fpc_project_id'],
                    'validity'              => $validity_request['approved_date'],
                    'updated_by'            => session('user')['user_id'],
                    'update_user_source_id' => session('user')['source_id']
                ]
            );

            $log_content = session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has approved FPC validity extension request from ' . Carbon::create($validity_request['validity'])->toFormattedDateString() . ' to ' . Carbon::create($validity_request['approved_date'])->toFormattedDateString() . '. Remarks : ' . $validity_request['approver_remarks'];
            $mail_recipient = $validity_request['approver_email'];
            $message =  'Successfully approved request!';
            $swal_type = 'success';
        }
        else if($validity_request['action'] == "reject"){
            $params = [
                'request_id'            => $validity_request['request_id'],
                'approved_date'         => $validity_request['approved_date'],
                'status'                => 5,                                       // status
                'approver_remarks'      => $validity_request['approver_remarks'],
                'updated_by'            => session('user')['user_id'],
                'update_user_source_id' => session('user')['source_id'],
                'update_date'          => Carbon::now()
            ];
            $m_validity_request->update_status($params);
            $log_content = session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has rejected the FPC validity extension request.'. 'Remarks : ' . $validity_request['approver_remarks'];
            $mail_recipient = $validity_request['approver_email'];
            $message =  'Request has been rejected.';
            $swal_type = 'error';
        }
        else if($validity_request['action'] == "create"){
            $pending = $m_validity_request->get_pending_request($validity_request['fpc_project_id']); 
            
            if(count($pending) > 0){
                return [
                    'status'  => false,
                    'message' => 'Unable to submit request, extension has been already sent.'
                ];
            }

            $params = [
                'fpc_project_id'        => $validity_request['fpc_project_id'],
                'request_date'          => $validity_request['request_date'],
                'requestor_remarks'     => $validity_request['requestor_remarks'],
                'original_validity_date' => $validity_request['validity_date'],
                'status'                => 7,                                      // pending
                'created_by'            => session('user')['user_id'],
                'create_user_source_id' => session('user')['source_id'],
                'creation_date'         => Carbon::now()
            ];

            $m_validity_request->insert_request($params);
            $log_content    = session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has created a request for FPC validity extension from ' . $validity_request['validity'] . ' to ' . Carbon::create($validity_request['request_date'])->toFormattedDateString()  . '. Remarks : ' . $validity_request['requestor_remarks'];
            $mail_recipient = $validity_request['approver_email'];
            $message        = 'Successfully submitted request!';
            $swal_type      = 'success';
        }
        else if($validity_request['action'] == "view"){
            return [
                    'status'  => false,
                    'message' => 'Unable to submit request, extension has been already sent.'
            ];
        }

        
        /* activity logs */
        $activity_log_params = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => $log_content,
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'reference_id'          => $validity_request['project_id'],
            'reference_column'      => 'project_id',
            'reference_table'       => 'fs_projects',
            'mail_flag'             => 'Y',
            'is_sent_flag'          => 'N',
            'timeline_flag'         => 'Y',
            'mail_recipient'        => $mail_recipient
        ];

        $m_activity_logs->insert_log($activity_log_params);
        
        return [
                'status'    => true,
                'message'   => $message,
                'swal_type' => $swal_type
            ];

    }

    public function revise(Request $request){
       /*  $m_fpc = new FPC;

        $fpc_id = $request->fpc_id;
        $m_fpc->update_status(
            $fpc_id, 
            null, // remarks 
            session('user')['user_id'],
            session('user')['source_id'],
            12 // in progress
        );

        return response()->json([
            'message' => 'You can now update the fpc details.',
            'status' => 'In progress'
        ]); */

        $moduleApproval = new ModuleApproval;
        DB::beginTransaction();

        try{
            $fpc_id = $request->fpc_id;
            $fpc = FPC::findOrFail($fpc_id);
            $fpc->status = 12;
            $fpc->current_approval_hierarchy = 1;
            $fpc->save();
            /* 
            $m_fpc->update_status(
                $fpc_id, 
                null, // remarks 
                session('user')['user_id'],
                session('user')['source_id'],
                7 // pending
            ); */

            $moduleApproval->revertFPCApproval($fpc_id);
            DB::commit();
            return response()->json([
                'message' => 'You can now update the fpc details.',
                'status' => 'In progress'
            ]);
        } catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred!',
                'status' => 'Pending'
            ]);
        }

    }

    public function submit(Request $request){
  
        $moduleApproval = new ModuleApproval;
        DB::beginTransaction();

        try{
            $fpc_id = $request->fpc_id;
            $fpc = FPC::findOrFail($fpc_id);
            $fpc->status = 7;
            $fpc->current_approval_hierarchy = 1;
            $fpc->save();
            /* 
            $m_fpc->update_status(
                $fpc_id, 
                null, // remarks 
                session('user')['user_id'],
                session('user')['source_id'],
                7 // pending
            ); */

            $moduleApproval->revertFPCApproval($fpc_id);
            DB::commit();
            return response()->json([
                'message' => 'FPC has been submitted',
                'status' => 'Pending'
            ]);
        } catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred!',
                'status' => 'Pending'
            ]);
        }
    }

    public function print_fpc_dealer_v2(
        Request $request,
        FPC_Project $m_fpc_project,
        SalesPersonsOra $m_sales_persons,
        FPC_Item $m_fpc_item,
        Approver $m_approver,
        FPCItemFreebies $m_freebies

    ){

       /*  if(!in_array(session('user')['user_type_id'], array(32,33)) ){
            return view('errors.404');
        } */

        $fpc_project_id = $request->fpc_project_id;
        $header_data    = $m_fpc_project->get_fpc_project_details($fpc_project_id);
        $sales_persons  = $m_sales_persons->get_sales_persons($header_data->project_id);
        $items          = $m_fpc_item->get_item_requirements($fpc_project_id);
        $signatories    = $m_approver->get_fpc_signatories($header_data->vehicle_type);
        $signatories    = collect($signatories)->groupBy('signatory_type');
        
      //  dd($signatories);
      
        $items_arr = [];
        foreach($items as $row){
            $arr = [
                'header' => $row,
                'other_items' => $m_freebies->get_item_freebies($row->fpc_item_id)
            ];

            array_push($items_arr, $arr);
        }
        
      
        $data = [
            'header_data'   => $header_data,
            'sales_persons' => $sales_persons,
            'items'         => $items_arr,
            'signatories'   => $signatories
        ];

        $pdf = PDF::loadView('pdf.print_fpc_dealer_v2', $data);
        return $pdf->setPaper('a4','portrait')->stream();
    }


}
