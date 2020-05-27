<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use App\Models\OrganizationTypes;
use App\Models\ProjectSources;
use App\Models\Customer;
use App\Models\SalesPersons;
use App\Models\VehicleType;
use App\Models\CustomerAffiliates;
use App\Models\Project;
use App\Models\CustomerContact;
use App\Models\ContactPersons;
use App\Models\SalesPersonsOra;
use App\Models\ProjectRequirement;
use App\Models\ProjectDeliverySchedule;
use App\Models\Competitor;
use App\Models\Approver;
use App\Models\ModuleApproval;
use App\Models\ActivityLogs;
use App\Models\Attachment;
use App\Models\Vehicle;
use App\Models\RequirementHeader;
use App\Models\RequirementLine;
use App\Models\FleetCategories;
use App\Models\FPC;
use App\Models\FPC_Item;
use App\Models\POHeaders;
use App\Models\FWPC;
use App\Models\Dealer;
use App\Models\FPCValidityRequest;
use App\Models\DealerPrincipal;
use DB;

class ProjectController extends Controller
{
    public function manage_project(
        Request $request, 
        OrganizationTypes $org_types, 
        ProjectSources $project_sources,
        Customer $customer,
        SalesPersons $sales_person,
        Vehicle $m_vehicle,
        Project $m_project,
        Attachment $m_attachment,
        CustomerAffiliates $m_affiliate
    ){
        
          //dd($project_details);
        $customer_id = null;
        $project_id = $request->project_id;
       
      
        $project_details        = $m_project->get_details($project_id);
        if(in_array(session('user')['user_type_id'], array(32,33)) ){
            $customer_id = $project_details->dealer_id;
        }
        else {
            $customer_id = session('user')['customer_id'];
        }
        $dp = new DealerPrincipal;

        $dealer_principal = \App\Models\DealerPrincipal::with('dealer')->where([
            ['status',1],
            ['dealer_id', $customer_id ]
        ])->get();
            
        
        $organizations    = $org_types->get_org_options();
        $project_sources  = $project_sources->get_project_sources_options();
        $customer_options = $customer->get_customer_options();
        $sales_persons    = $sales_person->get_sales_persons($customer_id);
        
    
        $vehicle_models   = $m_vehicle->get_active_vehicles();
        $vehicle_types    = VehicleType::all();
        $fleet_categories = FleetCategories::all();
        $grouped          = collect($vehicle_models)->groupBy('model_variant'); 
        $vehicle_options  = array();
        
        foreach($grouped as $model => $variant){
            
            $children = array();
            foreach($variant as $var){
                $temp_array = array(
                    "variant"      => $var->model_variant,
                    "sales_model"  => $var->sales_model,
                    "vehicle_type" => $var->vehicle_type
                );
                array_push($children,$temp_array);
            }
        
            $children = array_unique($children,SORT_REGULAR);
            $option = array(
                "model" => $model,
                "variants" => $children
            );
            array_push($vehicle_options, $option);
    
            /* 
            foreach($variant as $var){
                $temp_array = array(
                    "id"           => $var->inventory_item_id,
                    "value"        => $var->sales_model,
                    "vehicle_type" => $var->vehicle_type,
                    "variant"      => $var->model_variant
                );
                array_push($children,$temp_array);
            }
            $option = array(
                "model" => $model,
                "variants" => $children
            );
            array_push($vehicle_options, $option); */
        }

        //array_unique($vehicle_options);
        /* echo "<pre>";
        print_r($vehicle_options);
        die; */
        
        $project_id = $request->project_id;
    	$action = $request->action;  

        if($action == "create"){
            $page_title = "New Project";
        }
        else if($action == "edit"){
            $page_title = "Edit Project";
        }

    	$page_data = array(
    		'project_id'         => $project_id,
    		'action'             => $action,
    		'organizations'      => $organizations,
    		'project_sources'    => $project_sources,
    		'customer_options'   => $customer_options,
    		'sales_persons'      => $sales_persons,
    		'vehicle_models'     => $vehicle_options,
    		'vehicles'           => $vehicle_models,
    		'vehicle_types'      => $vehicle_types,
    		'base_url'           => url('/'),
    		'fleet_categories'   => $fleet_categories,
    		'page_title'         => $page_title,
    		'dealer_principal'   => $dealer_principal,
    		'vehicle_lead_times' => config('app.vehicle_lead_time'),
    		'user_type'          => session('user')['user_type_id']
    	);
    	return view('projects.manage_project', $page_data);
    }

    public function all_projects(Project $m_project){
        
        if(in_array(session('user')['user_type_id'], array(32,33)) ){
            $dealers = Dealer::all();
        }
        else {
            $dealers = Dealer::find(session('user')['customer_id']);
        }

        $page_data = array(
            'base_url'            => url('/'),
            'status_colors'       => config('app.status_colors'),
            'dealers'             => $dealers,
            'user_type'           => session('user')['user_type_id'],
            'customer_id'         => session('user')['customer_id'] == null ? "" : session('user')['customer_id'],
            'dealer_satellite_id' => session('user')['dealer_satellite_id'] == null ? "" : session('user')['dealer_satellite_id'],
        );

    	return view('projects.all_projects',$page_data);
    }

    public function project_overview(
        Request            $request,
        Customer           $m_customer,
        Project            $m_project,
        Attachment         $m_attachment,
        CustomerAffiliates $m_affiliates,
        CustomerContact    $m_contact,
        ContactPersons     $m_contact_person,
        SalesPersonsOra    $m_sales_person,
        RequirementHeader  $m_requirement,
        Competitor         $m_competitor,
        FPC                $m_fpc,
        FPC_Item           $m_fpc_item,
        POHeaders          $m_poh,
        FWPC               $m_fwpc,
        ActivityLogs       $m_activity_logs,
        FPCValidityRequest $m_validity_request 
    ){
        $project_id             = $request->project_id;
        $project_details        = $m_project->get_details($project_id);
        $customer_details       = $m_customer->get_customer_details_by_id($project_details->customer_id);
        $attachments            = $m_attachment->get_customer_attachments($project_details->customer_id);
        $affiliates             = $m_affiliates->get_customer_affiliates($project_details->customer_id);
        $contacts               = $m_contact->get_contacts($project_details->project_id);
        $contact_persons        = $m_contact_person->get_contact_persons($project_details->project_id);
        $sales_persons          = $m_sales_person->get_sales_persons($project_details->project_id);
        $requirement            = $m_requirement->get_requirements($project_details->project_id);
        $requirement            = collect($requirement)->groupBy('vehicle_type');
        $competitors            = $m_competitor->get_competitors($project_details->project_id);
        $competitor_attachments = $m_attachment->get_competitor_attachments($project_details->project_id);
        $vehicle_colors         = config('app.vehicle_badge_colors');
        $status_colors          = config('app.status_colors');
        $max_validity_date      = $m_fpc->get_max_validity_by_project($project_id);
        $add_po_flag            = false;
        $current_date           = date('Y-m-d H:i:s');
        $timeline               = $m_activity_logs->get_activities_by_project($project_id);

        // get all vehicle types based on requirement
        $vehicle_types_requirement = [];
        foreach ($requirement as $key => $value) {
            array_push($vehicle_types_requirement, $key);
        }
        // remove duplicates for vehicle types
        $vehicle_types_requirement = array_unique($vehicle_types_requirement);

        // fleet price confirmation
        $fpc_headers = $m_fpc->get_fpc_by_project($project_id);
        $vehicle_types_fpc = [];
        $fpc_data = [];

        foreach($fpc_headers as $fpc){
            $items = $m_fpc_item->get_item_requirements($fpc->fpc_project_id);
            $attachments  = $m_attachment->get_fpc_project_attachments($fpc->fpc_project_id);
            $temp_array = [
                'fpc_header' => $fpc,
                'fpc_lines'  => $items,
                'attachments' => $attachments,
                'pending_fpc_validity' => $m_validity_request->get_pending_request($fpc->fpc_project_id)
            ];
            array_push($vehicle_types_fpc, $fpc->vehicle_type);
            array_push($fpc_data,$temp_array);
        }
        $vehicle_types_fpc = array_unique($vehicle_types_fpc);
        
        // check if FPC has been created for all VEHICLE TYPE REQUIREMENTS
        $pending_fpc_vehicle_type = array_diff($vehicle_types_requirement,$vehicle_types_fpc);
        if(empty($pending_fpc_vehicle_type) && $current_date < $max_validity_date){
            // get max validity date from FPC Projects
            // compare to current to know if dealer can still add purchase orders
            // purchase orders can only added if FPC validity date is still covered
           // if($current_date < $max_validity_date){
            $add_po_flag = true;
           // }
        }

        // purchase orders
        $po_list = $m_poh->get_po_by_project($project_id);
        $vehicle_user_type = "";
        // fwpc list
        $fwpc = $m_fwpc->get_fwpc_by_project($project_id);

        if(session('user')['user_type_id'] == 32){
            $vehicle_user_type = 'LCV';
        }
        else if(session('user')['user_type_id'] == 33){
            $vehicle_user_type = 'CV';
        }

        $page_data = [
            'project_id'               => $request->project_id,
            'action'                   => $request->action,
            'approval_id'              => $request->approval_id,
            'project_details'          => $project_details,
            'customer_details'         => $customer_details,
            'attachments'              => $attachments,
            'competitors'              => $competitors,
            'affiliates'               => $affiliates,
            'requirement'              => $requirement,
            'contacts'                 => $contacts,
            'sales_persons'            => $sales_persons,
            'contact_persons'          => $contact_persons,
            'competitor_attachments'   => $competitor_attachments,
            'base_url'                 => url('/'),
            'vehicle_colors'           => $vehicle_colors,
            'status_colors'            => $status_colors,
            'fpc'                      => $fpc_data,
            'po_list'                  => $po_list,
            'fwpc'                     => $fwpc,
            'user_type'                => session('user')['user_type_id'],
            'vehicle_user_type'        => $vehicle_user_type,
            'add_po_flag'              => $add_po_flag,
            'timeline'                 => $timeline,
            'pending_fpc_vehicle_type' => $pending_fpc_vehicle_type
        ];
        return view('projects.project_overview', $page_data);
    }

    public function create_project_header(
        $m_project, 
        $m_module_approval,
        $m_approver,
        $customer_id, 
        $project_source_id,
        $account_details,
        $contact_details, 
        $competitor_flag, 
        $competitor_reason,
        $m_activity_logs
    ){
         // Project Details
        $project_params = [
            'customer_id'           => $customer_id,
            'dealer_id'             => session('user')['customer_id'],
            'project_source_id'     => $project_source_id,
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'email'                 => $contact_details['email_address'],
            'facebook_url'          => $contact_details['facebook_url'],
            'website_url'           => $contact_details['website_url'],
            'bid_ref_no'            => $account_details['bid_ref_no'],
            'bid_docs_amount'       => str_replace(',','',$account_details['bid_docs_amount']),
            'pre_bid_sched'         => $account_details['pre_bid_sched'],
            'bid_date_sched'        => $account_details['bid_date_sched'],
            'bidding_venue'         => $account_details['bidding_venue'],
            'approved_budget_cost'  => str_replace(',','',$account_details['approved_budget_cost']),
            'fleet_category'        => $account_details['fleet_category'],
            'competitor_flag'       => $competitor_flag, 
            'competitor_remarks'    => $competitor_reason, 
            'status'                => 3 // default status (NEW)
        ];

        $project_id = $m_project->insert_project($project_params);
        $this->insert_project_approval(
            'DLR_MANAGER',
            '', // vehicle type
            $project_id
        );
        return $project_id;
    }

    public function create_project_requirement($requirements,$project_id){   
        $lcv_requirement = $requirements['LCV'];
        $cv_requirement = $requirements['CV'];
        $m_module_approval = new ModuleApproval;
        $m_activity_logs = new ActivityLogs;
        $m_requirement_header = new RequirementHeader;
        $m_requirement_line = new RequirementLine;
        $m_requirement = new ProjectRequirement;
        $m_delivery_sched = new ProjectDeliverySchedule;

        if(!empty($lcv_requirement)){
            $params = [
                'vehicle_type'          => 'LCV',
                'project_id'            => $project_id,
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'status'                => 7 // Pending
            ];
            $lcv_requirement_id = $m_requirement_header->insert_requirement_header($params);

            foreach($lcv_requirement as $row){
                $line_params = [
                    'requirement_header_id' => $lcv_requirement_id,
                    'inventory_item_id'     => $row['inventory_item_id'],
                    'quantity'              => $row['quantity'],
                    'suggested_price'       => $row['suggested_price'],
                    'body_builder_name'     => $row['body_builder'],
                    'rear_body_type'        => $row['rear_body_type'],
                    'additional_items'      => $row['additional_details'],
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id']
                ];
                $requirement_line_id = $m_requirement_line->insert_requirement_line($line_params);

                foreach($row['delivery_schedule'] as $sched){
                    $sched_params = [
                        'requirement_line_id'   => $requirement_line_id,
                        'quantity'              => $sched['quantity'],
                        'delivery_date'         => $sched['delivery_date'],
                        'owner_id'              => 6, // dealer is the default owner
                        'module_id'             => 1, // Fleet Project module
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id']
                    ];
                    $m_delivery_sched->insert_delivery_schedule($sched_params);
                }
            }
        }

        if(!empty($cv_requirement)){
            $params = [
                'vehicle_type'          => 'CV',
                'project_id'            => $project_id,
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'status'                => 7 // Pending
            ];
            $cv_requirement_id = $m_requirement_header->insert_requirement_header($params);

    
            foreach($cv_requirement as $row){
                $line_params = [
                    'requirement_header_id' => $cv_requirement_id,
                    'inventory_item_id'     => $row['inventory_item_id'],
                    'quantity'              => $row['quantity'],
                    'suggested_price'       => $row['suggested_price'],
                    'body_builder_name'     => $row['body_builder'],
                    'rear_body_type'        => $row['rear_body_type'],
                    'additional_items'      => $row['additional_details'],
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id']
                ];
                $requirement_line_id = $m_requirement_line->insert_requirement_line($line_params);

                foreach($row['delivery_schedule'] as $sched){
                    $sched_params = [
                        'requirement_line_id'   => $requirement_line_id,
                        'quantity'              => $sched['quantity'],
                        'delivery_date'         => $sched['delivery_date'],
                        'module_id'             => 1, // Fleet Project module
                        'owner_id'              => 6, // dealer is the default owner
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id']
                    ];
                    $m_delivery_sched->insert_delivery_schedule($sched_params);
                }
            }
        }
    }   

    public function create_project_competitor($competitors, $project_id){
        $m_competitor = new Competitor;
        $competitor_params = [];
        foreach ($competitors as $row) {
            if(!isset($row['competitor_id']) && $row['delete_flag'] == 'N'){
                $temp = [
                    'project_id'            => $project_id,
                    'brand'                 => $row['brand'],
                    'model'                 => $row['model'],
                    'price'                 => $row['price'],
                    'ipc_item_id'           => $row['ipc_item_id'],
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                ];
            
                array_push($competitor_params,$temp);
            }

            if(isset($row['competitor_id'])){
                if($row['delete_flag'] == 'Y'){
                    $m_competitor->delete_competitor($row['competitor_id']);
                }
                else if($row['delete_flag'] == 'N'){
                    $m_competitor->update_competitor(
                        [
                            'competitor_id' => $row['competitor_id'],
                            'brand'         => $row['brand'],
                            'model'         => $row['model'],
                            'price'         => $row['price'],
                            'ipc_item_id'   => $row['ipc_item_id']
                        ]
                    );
                }
            }

            // create or update competitor master file
            $m_competitor->create_competitor(
                $row['brand'],
                $row['model'],
                session('user')['user_id'], 
                session('user')['source_id'],
                Carbon::now()
            );
        }   
        $m_competitor->insert_competitor($competitor_params);
    }

    public function create_project_activity_log($account_details,$project_id){
        $m_project = new Project;
        $m_activity_logs = new ActivityLogs;

        $project_details = $m_project->get_details($project_id);
        $activity_log_params = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => 'Project No. <strong>'. $project_id.'</strong> with account name <strong>' . $account_details['account_name'] . '</strong> has been <strong>created</strong>.',
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

        $m_activity_logs->insert_log($activity_log_params);
    }

    public function create_project_sales_persons($sales_persons, $project_id){
        $m_sales_persons = new SalesPersonsOra;
        $sales_persons_params = [];
        foreach ($sales_persons as $row) {
            if($row['delete_flag'] == 'N' && !isset($row['creation_date'])){
                $temp = [
                    'project_id'            => $project_id,
                    'name'                  => $row['name'],
                    'position'              => $row['position_title'],
                    'mobile_no'             => $row['mobile_no'],
                    'email_address'         => $row['email'],
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id']
                ];
                array_push($sales_persons_params, $temp);
            }
            else if(isset($row['creation_date']) && $row['delete_flag'] == 'Y') {
                $m_sales_persons->delete_sales_person($row['sales_person_id']);
            }
        }

        $m_sales_persons->insert_sales_person($sales_persons_params);
    }

    public function create_project_contacts($customer_contacts, $project_id){
        $m_customer_contact = new CustomerContact;
        $cust_contact_params = [];
        foreach($customer_contacts as $row){
            if($row['delete_flag'] == 'N' && !isset($row['contact_id'])){
                $arr = [
                    'project_id'     => $project_id,
                    'contact_number' => $row['contact_number']
                ];
                array_push($cust_contact_params,$arr);
            }
            else if($row['delete_flag'] == 'Y' && isset($row['contact_id'])) {
               $m_customer_contact->delete_contact($row['contact_id']);
            }
        }
        $m_customer_contact->insert_contact($cust_contact_params);
    }

    public function create_contact_persons($contact_persons, $project_id){
        $m_contact_person = new ContactPersons;

        $contact_person_params = [];
        foreach($contact_persons as $row){
            if($row['delete_flag'] == 'N'){
               if(isset($row['contact_person_id'])){
                    // update details
                    $m_contact_person->update_contact_person(
                        [
                            'contact_person_id'     => $row['contact_person_id'],
                            'name'                  => $row['name'],
                            'position_title'        => $row['position'],
                            'department'            => $row['department'],
                            'contact_number'        => $row['contact_number'],
                            'email_address'         => $row['email'],
                            'updated_by'            => session('user')['user_id'],
                            'update_user_source_id' => session('user')['source_id']
                        ]
                    );
               }
               else {
                    //insert
                   $temp = [
                        'project_id'            => $project_id,
                        'name'                  => $row['name'],
                        'position_title'        => $row['position'],
                        'department'            => $row['department'],
                        'contact_number'        => $row['contact_number'],
                        'email_address'         => $row['email'],
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id']
                    ];
                    array_push($contact_person_params, $temp);
                }
            }
            else if($row['delete_flag'] == 'Y' && isset($row['contact_person_id'])) {
                $m_contact_person->delete_contact_person($row['contact_person_id']);
            }

        }   
        $m_contact_person->insert_contact_persons($contact_person_params);
    }

    public function insert_project_customer($m_customer,$m_affiliates,$account_details){
         // Customer Details
        $customer_attrs = 
            // this will used for insert
            [
                'customer_name'         => $account_details['account_name']
            ];
        $customer_values = 
            // this will be used for other parameters to insert
            [
                //'customer_name'         => $account_details['account_name'],
                'organization_type_id'  => $account_details['selected_org_type'],
                'tin'                   => $account_details['tin'],
                'address'               => $account_details['address'],
                'business_style'        => $account_details['business_style'],
                'establishment_date'    => $account_details['establishment_date'],
                'products'              => $account_details['products'],
                'company_overview'      => $account_details['company_overview'],
                'status'                => 1, // active
                'created_by'            => session('user')['user_id'],
                'create_user_source_id' => session('user')['source_id'],
                'creation_date'         => Carbon::now()
            ];
       
        $customer_id = $m_customer->insert_customer($customer_attrs,$customer_values);
        // End of customer details
       
       // Affiliate details
        $affiliates = $account_details['affiliates'];
        $affiliate_params = [];
        foreach($affiliates as $row){
            $arr = [
                'customer_id'           => $customer_id,
                'customer_affiliate_id' => $row,
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id']
            ];
            array_push($affiliate_params,$arr);
        }

        if(!empty($affiliates)){
            $m_affiliates->delete_affiliate($customer_id);
        }

        $m_affiliates->insert_affiliates($affiliate_params);
        
        return $customer_id;
    }

    public function insert_project_approval($user_type,$vehicle_type,$project_id){
        $m_approver = new Approver;
        $m_module_approval = new ModuleApproval;
        $m_activity_logs = new ActivityLogs;
        // insert IPC approval
        $approvers = $m_approver->get_project_approvers(
            session('user')['user_id'],
            $user_type, //'IPC_STAFF',
            $vehicle_type
        );
    
        $approval_params = [];
        $activity_log = [];
  
        foreach($approvers as $row){
            $temp_arr = [
                'module_id'             => 1, // Fleet Project
                'module_reference_id'   => $project_id,
                'approver_id'           => $row->approver_id,
                'hierarchy'             => $row->hierarchy,
                'status'                => 7, // Pending
                'column_reference'      => 'project_id',
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'table_reference'       => 'fs_projects'
            ];
            array_push($approval_params,$temp_arr);
            $mail_flag = 'Y';

            /*if($row->user_type == 'IPC_STAFF') {
                $mail_flag = 'N';
            }*/
            
            $log_arr = [
                'module_id'             => 1, // Fleet Project
                'module_code'           => 'PRJ',
                'content'               => 'Project No. <strong>' . $project_id . '</strong> is waiting for your approval.',
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'reference_id'          => $project_id,
                'reference_column'      => 'project_id',
                'reference_table'       => 'fs_projects',
                'mail_flag'             => $mail_flag,
                'is_sent_flag'          => 'N',
                'timeline_flag'         => 'N',
                'mail_recipient'        => $row->email_address
            ];
            array_push($activity_log,$log_arr);
        }
        // insert approval
        $m_module_approval->insert_module_approval($approval_params);
        $m_activity_logs->insert_log($activity_log);
    }

    public function create_project_source($account_details){
        // Project Source
        $project_source_id = 0; 
        $projectSource = new ProjectSources;
        // project source
        if($account_details['selected_project_source'] == 8){
            $project_source_id = $projectSource->insert_project_source(
                [
                    'source_name' => $account_details['others']
                ]
            ); 
        }
        else {
            $project_source_id = $account_details['selected_project_source'];
        }

        return $project_source_id;
    }

    public function upload_project_attachment(Request $request, Attachment $m_attachment){
        $attachment             = $request->attachment;
        $competitor_attachments = $request->competitor_attachments;
        $project_id             = $request->project_id;
        $customer_id            = $request->customer_id;
        $attachment_params      = [];
        $competitor_params      = [];
        $file_index             = 0;
        

        if(!empty($_FILES)){

            if(!empty($attachment)){
                $customer_attachments = $m_attachment->get_customer_attachments($customer_id);
                foreach($customer_attachments as $row){
                    $file_path = storage_path('app/public/customer/'.$row['filename']); 
                    unlink($file_path);
                }
                // if new attachment has been placed, delete the old data.
                $m_attachment->delete_attachment($customer_id);
                foreach($attachment as $file){
                    //Move Uploaded File
                    $filename = Carbon::now()->timestamp . $file_index . '.' . $file->getClientOriginalExtension();
                    $orig_filename = $file->getClientOriginalName();
                    $customerPath = Storage::putFileAs(
                        'public/customer', $file, $filename
                    );                    
                    $temp = [
                        'filename'              => $filename,
                        'directory'             => $customerPath,
                        'module_id'             => 1, // Fleet project
                        'reference_id'          => $customer_id,
                        'reference_table'       => 'fs_customers',
                        'reference_column'      => 'customer_id',
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id'],
                        'orig_filename'         => $orig_filename,
                        'owner_id'              => 2, // customer as owner
                        'symlink_dir'           => 'public/storage/customer/'

                    ];         
                    array_push($attachment_params,$temp);
                    ///$file->move($destinationPath,$filename);
                    $file_index++;
                }
            }

            if(!empty($competitor_attachments)){
                 // delete previous files
                $attachments = $m_attachment->get_competitor_attachments($project_id);  
                foreach($attachments as $row){
                $file_path = storage_path('app/public/competitor/'.$row['filename']); 
                    unlink($file_path);
                }
                // if new attachment has been placed, delete the old data.
                $m_attachment->delete_competitor_attachment($project_id);
                foreach($competitor_attachments as $file){
                   
                    //Move Uploaded File 
                    $filename = Carbon::now()->timestamp . $file_index . '.' . $file->getClientOriginalExtension();
                    $orig_filename = $file->getClientOriginalName();
                    $competitorPath = Storage::putFileAs(
                        'public/competitor', $file, $filename
                    ); 
                    $temp = [
                        'filename'              => $filename,
                        'directory'             => $competitorPath,
                        'module_id'             => 1, // Fleet project
                        'reference_id'          => $project_id,
                        'reference_table'       => 'fs_projects',
                        'reference_column'      => 'project_id',
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id'],
                        'orig_filename'         => $orig_filename,
                        'owner_id'              => 1,// competitor as owner of the file
                        'symlink_dir'           => 'public/storage/competitor/'
                    ];         
                    array_push($attachment_params,$temp);
                   // $file->move($destinationPath,$filename);
                    $file_index++;
                }
            }
            $m_attachment->insert_attachment($attachment_params);
        }
        return response()->json(
            [
                'status' => "success",
                'project_id' => $project_id,
                'customer_id' => $customer_id
            ]
        );
    }



    public function project_approval(ModuleApproval $m_approval){

        $approval_list = $m_approval->get_projects_approval(
            session('user')['customer_id'],
            session('user')['user_id'],
            session('user')['source_id'],
            session('user')['user_type_id']
        );

        $page_data = [
            'approval_list' => $approval_list,
            'base_url'         =>  url('/')
        ];
        return view('projects.project_approval',$page_data); 
    }

    public function save_approval(
        Request $request, 
        ModuleApproval $m_approval, 
        Project $m_project,
        ActivityLogs $m_activity_logs,
        RequirementHeader $m_rh,
        Approver $m_approver
    ){
        $project_id      = $request->projectId;
        $approval_id     = $request->approvalId;
        $remarks         = $request->remarks;
        $status          = $request->status;
        $project_details = $m_project->get_details($project_id);
        $status_id       = 0;

        if($status == "approve"){
            $status_id = 4; // approve
        }
        else if($status == "reject"){
            $status_id = 5; // reject
        }
        
        // save status for ipc_dms.fs_module_approval table
        $m_approval->save_approval(
            $approval_id, 
            $project_id, // module_reference_id, 
            'fs_projects', 
            'project_id', 
            $status_id, 
            $remarks,
            session('user')['user_id'],
            session('user')['source_id']
        );

        // update requirement header status ipc_dms.fs_prj_requirement_headers
        if(session('user')['user_type_id'] == 32){
            $vehicle_user_type = 'LCV';
            $m_rh->update_status(
                $project_id,
                $status_id,
                'LCV',
                session('user')['user_id'],
                session('user')['source_id']
            );
        }
        else if(session('user')['user_type_id'] == 33){
            $vehicle_user_type = 'CV';
            $m_rh->update_status(
                $project_id,
                $status_id,
                'CV',
                session('user')['user_id'],
                session('user')['source_id']
            );
        }

        // email to requestor
        $status_remarks = $status == "approve" ? "<strong>approved</strong>" : "<strong>rejected</strong>"; 
        $message = 'Project No. <strong>' . $project_id . '</strong> has been ' . $status_remarks . ' by <strong>' . session('user')['first_name'] . ' ' . session('user')['last_name'] . '</strong>.';
        if($remarks != ""){
            $message .= '<br/>Remarks : ' . $remarks;
        }
        $activity_log_params = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => $message,
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

        $m_activity_logs->insert_log($activity_log_params);

        // count pending approval for dealers
      //  $pending_approval = $m_approval->get_pending_per_project($project_id,'DLR_MANAGER');
        
        // if no pending approval for dealers INSERT IPC approvers by getting requirements
        // set project status as PENDING
        if(
           // count($pending_approval)           == 0 &&  // if no pending approval from other dealer approver
            $status                            == "approve"  // if approve
            && session('user')['user_type_id'] == 31 // dealer manager
        ){
            
            // update status of project to open in ipc_dms.fs_projects
            $m_project->update_status(
                $project_id,
                7, // set project status AS PENDING 
                session('user')['user_id'],
                session('user')['source_id']
            );

            //$project_details = $m_project->get_details($project_id)
            // get vehicle type requirement
            $requirement_headers = $m_rh->get_headers($project_id);
            foreach($requirement_headers as $row){
               $this->insert_project_approval(
                    'IPC_STAFF',
                    $row->vehicle_type,
                    $project_id
                ); 
            }
    
        }
        else {
          
            // if user is Dealer Manager, once reject by other approvers, project already rejected
            if(session('user')['user_type_id'] == 31 && $status == 'reject'){
               
                $m_project->update_status(
                    $project_id,
                    5, // rejected 
                    session('user')['user_id'],
                    session('user')['source_id']
                );
            }
            // DEPRECATED : if user is LCV is CV user, project will only be rejected in All of the approvers rejected the project
            // if user has REJECTED , entire project is reject           
            else if(in_array(session('user')['user_type_id'],array(32,33))){
                $approval = $m_approval->get_project_approval_workflow($project_id);
                 
                $lcv_approve = false;
                $cv_approve = false;
                $total_lcv = 0;
                $total_cv = 0;
                foreach ($approval as $row) {
                    if($row->user_type == 'IPC_STAFF' && $row->vehicle_type == 'LCV'){
                        if($row->status == 4){
                            $lcv_approve = true;
                        }
                        $total_lcv++;
                    }

                    if($row->user_type == 'IPC_STAFF' && $row->vehicle_type == 'CV'){
                        if($row->status == 4){
                            $cv_approve = true;
                        }
                        $total_cv++;
                    }
                }

                if($total_lcv == 0){ // if there are no approvers from LCV set approved to TRUE
                    $lcv_approve = true;
                }
                if($total_cv == 0){ // if there are no approvers from CV set approved to TRUE
                    $cv_approve = true;
                }

               // if($total_approvers == $total_approve){
                if($lcv_approve && $cv_approve) {
                    $m_project->update_status(
                        $project_id,
                        11, // open 
                        session('user')['user_id'],
                        session('user')['source_id']
                    ); 
                    /*if($project_status == 11 && session('user')['user_type_id'] == 31){*/
                    $activity_log_params = [
                        'module_id'             => 1, // Fleet Project
                        'module_code'           => 'PRJ',
                        'content'               => 'Your Project No. <strong>' . $project_id . '</strong> has been <strong>opened.</strong>',
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
                    $m_activity_logs->insert_log($activity_log_params);
                    /*} */                  
                }
                
                if($status == "reject"){
                    $m_project->update_status(
                        $project_id,
                        5, // rejected 
                        session('user')['user_id'],
                        session('user')['source_id']
                    );
                
                   foreach ($approval as $row) {
                        if($row->user_type == 'IPC_STAFF'){
                            $m_approval->delete_approval($row->approval_id);
                        }
                    }
                }
                
            }
        }

        
    }

    public function ajax_cancel_project(Request $request, Project $m_project){
        $project_id = $request->project_id;
        $status_id = 6; // cancelled

        $m_project->update_status(
            $project_id,
            $status_id,
            session('user')['user_id'],
            session('user')['source_id']
        );

        return [
            'status' => 'Cancelled'
        ];
    }

    public function ajax_close_project(
        Request $request, 
        Project $m_project,
        ActivityLogs $m_activity_logs
    ){
        $project_id = $request->project_id;
        $status_id = 13; // closed

        $project_details = $m_project->get_details($project_id);    
        $m_project->update_status(
            $project_id,
            $status_id,
            session('user')['user_id'],
            session('user')['source_id']
        );

        $activity_log_params = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => 'Project No. <strong>' . $project_id . '</strong> has been <strong>closed</strong> by <strong>' . session('user')['first_name'] . ' ' . session('user')['last_name'] . '</strong>.',
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

        $m_activity_logs->insert_log($activity_log_params);

        return [
            'status' => 'Closed'
        ];
    }

    public function ajax_reopen_project(
        Request $request, 
        Project $m_project,
        ActivityLogs $m_activity_logs
    ){
        $project_id = $request->project_id;
        $status_id = 11; // submitted

        $project_details = $m_project->get_details($project_id);    
        $m_project->update_status(
            $project_id,
            $status_id,
            session('user')['user_id'],
            session('user')['source_id']
        );

        $activity_log_params = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => 'Project No. <strong>' . $project_id . '</strong> has been <strong>re-opened</strong> by <strong>' . session('user')['first_name'] . ' ' . session('user')['last_name'] . '</strong>.',
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

        $m_activity_logs->insert_log($activity_log_params);

        return [
            'status' => 'Open'
        ];
    }

    public function ajax_get_filtered_projects(Request $m_request, Project $m_project){
        $customer_id         = $m_request->customer_id;
        $start_date          = $m_request->start_date;
        $end_date            = $m_request->end_date;
        $dealer              = $m_request->dealer;
        $status              = $m_request->status;
        $dealer_satellite_id = $m_request->dealer_satellite_id;
        $projects            = $m_project->get_filtered_projects(
            session('user')['user_type_id'],
            $dealer,
            $start_date,
            $end_date,
            $customer_id,
            $status,
            session('user')['user_id'],
            session('user')['source_id'],
            $dealer_satellite_id
        );
        return $projects;
    }

    public function get_project_details(
        Request                 $request, 
        Project                 $m_project,
        CustomerContact         $m_contact,
        ContactPersons          $m_contact_person,
        SalesPersonsOra         $m_sales_person,
        RequirementHeader       $m_requirement,
        ProjectDeliverySchedule $m_delivery_sched,
        Competitor              $m_competitor,
        Attachment $m_attachment
    ){
        $project_id             = $request->project_id;
        $project_details        = $m_project->get_details($project_id);
        $contacts               = $m_contact->get_contacts($project_details->project_id);
        $contact_persons        = $m_contact_person->get_contacts($project_details->project_id);
        $sales_persons          = $m_sales_person->get_sales_persons($project_details->project_id);
        $sales_persons_arr      = [];
        $requirement            = $m_requirement->get_requirements($project_details->project_id);
        $requirement_arr        = [];
        $competitors            = $m_competitor->get_competitors($project_details->project_id);
        $competitor_attachments = $m_attachment->get_competitor_attachments($project_details->project_id);

        // contacts
        $contacts_arr = [];
        foreach($contacts as $con){
            array_push(
                $contacts_arr,
                [
                    'contact_id'     => $con->contact_id,
                    'contact_number' => $con->contact_number,
                    'delete_flag'    => 'N'
                ]
            );
        }

        // contact persons
        $contact_persons_arr = [];
        foreach($contact_persons as $cp){
            array_push(
                $contact_persons_arr,
                [
                    'contact_person_id' => $cp->contact_person_id,
                    'name'              => $cp->name,
                    'email'             => $cp->email,
                    'department'        => $cp->department,
                    'contact_number'    => $cp->contact_number,
                    'position'          => $cp->position,
                    'delete_flag'       => 'N'
                ]
            );
        }

        // requirement
        foreach($requirement as $req){
            $delivery_sched = $m_delivery_sched->get_project_delivery_schedule($req->requirement_line_id);
            $arr = [
                'requirement_line_id' => $req->requirement_line_id,
                'vehicle_type'        => $req->vehicle_type,
                'inventory_item_id'   => $req->inventory_item_id,
                'sales_model'         => $req->sales_model,
                'color'               => $req->color,
                'quantity'            => $req->quantity,
                'suggested_price'     => $req->suggested_price,
                'body_builder_name'   => $req->body_builder_name,
                'rear_body_type'      => $req->rear_body_type,
                'additional_items'    => $req->additional_items,
                'variant'             => $req->model_variant,
                'delivery_schedule'   => $delivery_sched
            ];
            array_push($requirement_arr,$arr);
        }

        // sales persons
        foreach($sales_persons as $sp){
            array_push(
                $sales_persons_arr,
                [
                    'sales_person_id' => $sp->sales_person_id,
                    'email'           => $sp->email_address,
                    'mobile_no'       => $sp->mobile_no,
                    'name'            => $sp->name,
                    'position_title'  => $sp->position,
                    'creation_date'   => $sp->creation_date,
                    'delete_flag'     => 'N'
                ]
            );
        }

        // competitors
        $competitors_arr = [];
        foreach($competitors as $comp){
            array_push(
                $competitors_arr,
                [
                    'brand'         => $comp->brand,
                    'ipc_color'     => $comp->color,
                    'ipc_item_id'   => $comp->ipc_item_id,
                    'ipc_model'     => $comp->sales_model,
                    'model'         => $comp->model,
                    'price'         => $comp->price,
                    'competitor_id' => $comp->competitor_id,
                    'delete_flag'   => 'N'

                ]
            );
        }

        $data = [
            'project_details'        => $project_details,
            'contacts'               => $contacts_arr,
            'contact_persons'        => $contact_persons_arr,
            'sales_persons'          => $sales_persons_arr,
            'requirement'            => $requirement_arr,
            'competitors'            => $competitors_arr,
            'competitor_attachments' => $competitor_attachments
        ];
        return response()->json($data);
    }

    public function updateRequirement($requirements,$project_id){
        $m_requirement_header = new RequirementHeader;
        $m_requirement_line = new RequirementLine;
        $m_delivery_sched = new ProjectDeliverySchedule;

        $lcv_requirement = $requirements['LCV'];
        $cv_requirement = $requirements['CV'];

        $requirement_headers = $m_requirement_header->get_headers($project_id);
        $requirement_headers = collect($requirement_headers)->groupBy('vehicle_type');


        // delete LCV requirement header and approvers if no lcv requirement is left
        if(empty($lcv_requirement)){
            if(!empty($requirement_headers['LCV'])){
                $m_requirement_header->delete_header($requirement_headers['LCV'][0]->requirement_header_id);
            }
        }

        // delete CV requirement header and approvers if no cv requirement is left
        if(empty($cv_requirement)){
            if(!empty($requirement_headers['CV'])){
                $m_requirement_header->delete_header($requirement_headers['CV'][0]->requirement_header_id);
            }
        }
  
       if(!empty($lcv_requirement)){

            if(!empty($requirement_headers['LCV'])){
                $lcv_requirement_id = $requirement_headers['LCV'][0]->requirement_header_id;
            }
            else {
                $params = [
                    'vehicle_type'          => 'LCV',
                    'project_id'            => $project_id,
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                    'status'                => 7 // Pending
                ];
                $lcv_requirement_id = $m_requirement_header->insert_requirement_header($params);
            }
            foreach($lcv_requirement as $row){
                // this is new records to be inserted
                if(!isset($row['requirement_line_id'])){
                    $line_params = [
                        'requirement_header_id' => $lcv_requirement_id,
                        'inventory_item_id'     => $row['inventory_item_id'],
                        'quantity'              => $row['quantity'],
                        'suggested_price'       => $row['suggested_price'],
                        'body_builder_name'     => $row['body_builder'],
                        'rear_body_type'        => $row['rear_body_type'],
                        'additional_items'      => $row['additional_details'],
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id']
                    ];
                    $requirement_line_id = $m_requirement_line->insert_requirement_line($line_params);
                    foreach($row['delivery_schedule'] as $sched){
                        $sched_params = [
                            'requirement_line_id'   => $requirement_line_id,
                            'quantity'              => $sched['quantity'],
                            'delivery_date'         => $sched['delivery_date'],
                            'module_id'             => 1, // Fleet Project module
                            'owner_id'              => 6, // dealer is the default owner
                            'created_by'            => session('user')['user_id'],
                            'creation_date'         => Carbon::now(),
                            'create_user_source_id' => session('user')['source_id']
                        ];
                        $m_delivery_sched->insert_delivery_schedule($sched_params);
                    }
                }
                // to only update records
                else {
                    $m_requirement_line->updateRequirement($row);
                }
            }
        }

        if(!empty($cv_requirement)){
            if(!empty($requirement_headers['CV'])){
                $cv_requirement_id = $requirement_headers['CV'][0]->requirement_header_id;
            }
            else {
                $params = [
                    'vehicle_type'          => 'CV',
                    'project_id'            => $project_id,
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                    'status'                => 7 // Pending
                ];
                $cv_requirement_id = $m_requirement_header->insert_requirement_header($params);
            }
            foreach($cv_requirement as $row){
                // this is new records to be inserted
                if(!isset($row['requirement_line_id'])){
                    $line_params = [
                        'requirement_header_id' => $cv_requirement_id,
                        'inventory_item_id'     => $row['inventory_item_id'],
                        'quantity'              => $row['quantity'],
                        'suggested_price'       => $row['suggested_price'],
                        'body_builder_name'     => $row['body_builder'],
                        'rear_body_type'        => $row['rear_body_type'],
                        'additional_items'      => $row['additional_details'],
                        'created_by'            => session('user')['user_id'],
                        'creation_date'         => Carbon::now(),
                        'create_user_source_id' => session('user')['source_id']
                    ];
                    $requirement_line_id = $m_requirement_line->insert_requirement_line($line_params);

                    foreach($row['delivery_schedule'] as $sched){
                        $sched_params = [
                            'requirement_line_id'   => $requirement_line_id,
                            'quantity'              => $sched['quantity'],
                            'delivery_date'         => $sched['delivery_date'],
                            'module_id'             => 1, // Fleet Project module
                            'owner_id'              => 6, // dealer is the default owner
                            'created_by'            => session('user')['user_id'],
                            'creation_date'         => Carbon::now(),
                            'create_user_source_id' => session('user')['source_id']
                        ];
                        $m_delivery_sched->insert_delivery_schedule($sched_params);
                    }
                }
                // to only update records
                else {
                    $m_requirement_line->updateRequirement($row);
                }
            }
        }
    }
    
    public function print_project(
        Request $request,
        Project $m_project,
        CustomerContact $m_contact,
        ContactPersons $m_contact_person,
        RequirementHeader  $m_requirement,
        Competitor  $m_competitor
    ){
        $m_sales_person = new SalesPersonsOra;
        $project_id      = $request->project_id;
        $project_details = $m_project->get_details($project_id);
        $contacts        = $m_contact->get_contacts($project_details->project_id);
        $contact_persons = $m_contact_person->get_contact_persons($project_details->project_id);
        $requirement     = $m_requirement->get_requirements($project_details->project_id);
        $requirement     = collect($requirement)->groupBy('vehicle_type');
        $competitors     = $m_competitor->get_competitors($project_details->project_id);
        $sales_persons   = $m_sales_person->get_sales_persons($project_details->project_id);
        $data = [
            'project_details' => $project_details,
            'contacts'        => $contacts,
            'contact_persons' => $contact_persons,
            'requirement'     => $requirement,
            'competitors'     => $competitors,
            'sales_persons'   => $sales_persons
        ];
  

        $pdf = PDF::loadView('pdf.print_project', $data);
        return $pdf->setPaper('a4','portrait')->stream();
    }

    public function create_project_customer($account_details){
         // Customer Details
        $customer_attrs = 
            // this will used for insert
            [
                'customer_name'         => $account_details['account_name']
            ];
        $customer_values = 
            // this will be used for other parameters to insert
            [
                //'customer_name'         => $account_details['account_name'],
                'organization_type_id'  => $account_details['selected_org_type'],
                'tin'                   => $account_details['tin'],
                'address'               => $account_details['address'],
                'business_style'        => $account_details['business_style'],
                'establishment_date'    => $account_details['establishment_date'],
                'products'              => $account_details['products'],
                'company_overview'      => $account_details['company_overview'],
                'status'                => 1, // active
                'created_by'            => session('user')['user_id'],
                'create_user_source_id' => session('user')['source_id'],
                'creation_date'         => Carbon::now()
            ];

        $customer = new Customer;
        $customer_id = $customer->insert_customer($customer_attrs,$customer_values);
        // End of customer details
       
        // Affiliate details
        $affiliate = new CustomerAffiliates;
        $affiliates = $account_details['affiliates'];
        $affiliate_params = [];
        foreach($affiliates as $row){
            $arr = [
                'customer_id'           => $customer_id,
                'customer_affiliate_id' => $row,
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id']
            ];
            array_push($affiliate_params,$arr);
        }

        if(!empty($affiliates)){
            $affiliate->delete_affiliate($customer_id);
        }

        $affiliate->insert_affiliates($affiliate_params);
        
        return $customer_id;
    }

    public function store(Request $request){    
        $account_details   = $request['accountDetails'];
        $contact_details   = $request['contactDetails'];
        $competitor_flag   = $request['competitor_flag'];
        $competitor_reason = $request['no_competitor_reason'];
        $project_id        = $request['project_id'];
        $project_status    = $request['status'];
        DB::beginTransaction();
        
        try {

            // project source
            $projectSource = new ProjectSources;
            $project_source_id = $this->create_project_source($account_details);

            // customer
            $customer_id = $this->create_project_customer($account_details);
            
            // project header
            $project_params = [
                'customer_id'           => $customer_id,
                'dealer_id'             => session('user')['customer_id'],
                'project_source_id'     => $project_source_id,
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'email'                 => $contact_details['email_address'],
                'facebook_url'          => $contact_details['facebook_url'],
                'website_url'           => $contact_details['website_url'],
                'bid_ref_no'            => $account_details['bid_ref_no'],
                'bid_docs_amount'       => str_replace(',','',$account_details['bid_docs_amount']),
                'pre_bid_sched'         => $account_details['pre_bid_sched'],
                'bid_date_sched'        => $account_details['bid_date_sched'],
                'bidding_venue'         => $account_details['bidding_venue'],
                'approved_budget_cost'  => str_replace(',','',$account_details['approved_budget_cost']),
                'fleet_category'        => $account_details['fleet_category'],
                'competitor_flag'       => $competitor_flag, 
                'competitor_remarks'    => $competitor_reason, 
                'status'                => $project_status // draft status
            ];
            
            $project = new Project;

            $project_id = $project->insert_project($project_params);
            
            $this->create_project_contacts($contact_details['custContacts'], $project_id);
            
            $this->create_contact_persons($contact_details['contactPersons'], $project_id);

            $this->create_project_sales_persons($contact_details['salesPersons'],$project_id);

            $this->create_project_requirement($request['requirement'],$project_id);

            $this->create_project_competitor($request['competitors'], $project_id);
    
            $this->create_project_activity_log($account_details,$project_id); 

            DB::commit();
            return response()->json([
                'status' => "success",
                'project_id' => $project_id,
                'customer_id' => $customer_id
            ]);

        } catch(\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function update(Request $request){
        ini_set('memory_limit', '256M');
        $account_details = $request['accountDetails'];
        $contact_details = $request['contactDetails'];
        $project_id = $request->project_id;
        // create project source
        $project_source_id = $this->create_project_source($account_details);
        // create or update customer data
        $customer_id = $this->create_project_customer($account_details);
        
        $project_status    = $request['status'];
        // update project header
        $project_params = [
            'customer_id'           => $customer_id,
            'project_source_id'     => $project_source_id,
            'updated_by'            => session('user')['user_id'],
            'update_user_source_id' => session('user')['source_id'],
            'email'                 => $contact_details['email_address'],
            'facebook_url'          => $contact_details['facebook_url'],
            'website_url'           => $contact_details['website_url'],
            'bid_ref_no'            => $account_details['bid_ref_no'],
            'bid_docs_amount'       => $account_details['bid_docs_amount'],
            'pre_bid_sched'         => $account_details['pre_bid_sched'],
            'bid_date_sched'        => $account_details['bid_date_sched'],
            'bidding_venue'         => $account_details['bidding_venue'],
            'approved_budget_cost'  => $account_details['approved_budget_cost'],
            'fleet_category'        => $account_details['fleet_category'],
            'competitor_flag'       => $request->competitor_flag, 
            'competitor_remarks'    => $request->no_competitor_reason, 
            'status'                => $project_status, // new
            'project_id'            => $project_id
        ];

        $m_project = new Project;
        $m_project->update_project($project_params);  
        $project_details = $m_project->get_details($project_id);
        $activity_log = [];
        array_push(
            $activity_log,
            [
                'module_id'             => 1, // Fleet Project
                'module_code'           => 'PRJ',
                'content'               => 'Project No. <strong>'. $project_id.'</strong> with account name <strong>' . $account_details['account_name'] . '</strong> has been <strong>updated</strong>.',
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
            ]
        );
        
        /*$approval_workflow = $m_module_approval->get_project_approval_workflow($project_id);
        foreach($approval_workflow as $row){
            // update approval status to pending  
            $m_module_approval->save_approval(
                $row->approval_id, 
                $row->project_id, // module_reference_id, 
                'fs_projects', 
                'project_id', 
                7, // set to pending again 
                $row->remarks,
                session('user')['user_id'],
                session('user')['source_id']
            );

            // 
            $log_arr = [
                'module_id'             => 1, // Fleet Project
                'module_code'           => 'PRJ',
                'content'               => 'Project No. <strong>' . $project_id . '</strong> has been updated and waiting for your approval.',
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'reference_id'          => $project_id,
                'reference_column'      => 'project_id',
                'reference_table'       => 'fs_projects',
                'mail_flag'             => 'Y',
                'is_sent_flag'          => 'N',
                'timeline_flag'         => 'N',
                'mail_recipient'        => $row->email_address
            ];
            array_push($activity_log,$log_arr);
        }
        // insert logs
        $m_activity_logs->insert_log($activity_log);*/


         // project contact number 
        $this->create_project_contacts(
            $contact_details['custContacts'], 
            $project_id
        );
  
        // project contact persons
        $this->create_contact_persons(
            $contact_details['contactPersons'], 
            $project_id
        );

        // project sales persons       
        $this->create_project_sales_persons(
            $contact_details['salesPersons'], 
            $project_id
        );

        // updating of requirements

        $this->updateRequirement($request['requirement'],$project_id);
        
        // project competitor
        $this->create_project_competitor($request['competitors'], $project_id);
        
        return response()->json(
            [
                'status' => "success",
                'project_id' => $project_id,
                'customer_id' => $customer_id
            ]
        );
     
    }

    public function submit(Request $request){
        $project_id = $request->project_id;
        $project = new Project;
        // create approval workflow
        
        
        // only update status if dealer
        // update status to new
        if(!in_array(session('user')['user_type_id'], array(32,33)) ){

            $this->insert_project_approval('DLR_MANAGER','',$project_id);
            
            $project->update_status(
                $project_id,
                3, // new status 
                session('user')['user_id'],
                session('user')['source_id']
            );
        }

        return response()->json(
            [
                'status' => "success",
                'project_id' => $project_id
            ]
        ); 
    }


     
 
}
