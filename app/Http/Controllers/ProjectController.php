<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
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

class ProjectController extends Controller
{
    
    public function manage_project(
        Request $request, 
        OrganizationTypes $org_types, 
        ProjectSources $project_sources,
        Customer $customer,
        SalesPersons $sales_person
        
    ){
        
      
        $organizations    = $org_types->get_org_options();
        $project_sources  = $project_sources->get_project_sources_options();
        $customer_options = $customer->get_customer_options();
     //   $customer_names   = $customer->get_customer_names();
        //$customer_names   = array_column($customer_names,'customer_name');
        $sales_persons    = $sales_person->get_sales_person_options(session('user')['customer_id']);
        $vehicle_types    = VehicleType::all();

        $price_confirmation_id = $request->price_confirmation_id;
    	$action = $request->action;
    	
    	$page_data = array(
    		'price_confirmation_id' => $price_confirmation_id,
    		'action'                => $action,
            'organizations'    => $organizations,
            'project_sources'  => $project_sources,
            'customer_options' => $customer_options,
           // 'customer_names'   => $customer_names,
            'sales_persons'    => $sales_persons,
            'vehicle_types'    => $vehicle_types,
            'base_url'         =>  url('/')
    	);
    	return view('projects.manage_project', $page_data);
    }

    public function all_projects(Project $m_project){
        $projects = $m_project->get_projects(
            session('user')['user_type_id'],
            session('user')['customer_id']
        );

      //  return $projects;
        $page_data = array(
            'projects' => $projects,
            'base_url' => url('/')
        );

    	return view('projects.all_projects',$page_data);
    }

    public function project_overview(
        Request $request,
        Customer $m_customer,
        Project $m_project,
        Attachment $m_attachment,
        CustomerAffiliates $m_affiliates,
        CustomerContact $m_contact,
        ContactPersons $m_contact_person,
        SalesPersonsOra $m_sales_person,
        ProjectRequirement $m_requirement,
        Competitor $m_competitor
    ){
        $project_details  = $m_project->get_details($request->project_id);
        $customer_details = $m_customer->get_customer_details_by_id($project_details->customer_id);
        $attachments      = $m_attachment->get_customer_attachments($project_details->customer_id);
        $affiliates       = $m_affiliates->get_customer_affiliates($project_details->customer_id);
        $contacts         = $m_contact->get_contacts($project_details->project_id);
        $contact_persons  = $m_contact_person->get_contact_persons($project_details->project_id);
        $sales_persons    = $m_sales_person->get_sales_persons($project_details->project_id);
        $requirement      = $m_requirement->get_requirement($project_details->project_id);
        $competitors      = $m_competitor->get_competitors($project_details->project_id);

        $page_data = [
            'project_id'       => $request->project_id,
            'action'           => $request->action,
            'approval_id'      => $request->approval_id,
            'project_details'  => $project_details,
            'customer_details' => $customer_details,
            'attachments'      => $attachments,
            'competitors'      => $competitors,
            'affiliates'       => $affiliates,
            'requirement'      => $requirement,
            'contacts'         => $contacts,
            'sales_persons'    => $sales_persons,
            'contact_persons'  => $contact_persons,
            'base_url'         => url('/')
        ];
        return view('projects.project_overview', $page_data);
    }

    public function save_project(
        Request $request,
        Customer $customer,
        ProjectSources $project_sources,
        CustomerAffiliates $customer_affiliates,
        Project $project,
        CustomerContact $customer_contact,
        ContactPersons $m_contact_person,
        SalesPersonsOra $m_sales_persons,
        ProjectRequirement $m_requirement,
        ProjectDeliverySchedule $m_delivery_sched,
        Competitor $m_competitor,
        Approver $m_approver,
        ModuleApproval $m_module_approval,
        ActivityLogs $m_activity_logs
    ){
        ini_set('memory_limit', '256M');
        
        $account_details = $request['accountDetails'];
        $contact_details = $request['contactDetails'];
        $project_source_id = 8;
        
        // Project Source
        if($account_details['selected_project_source'] == 8){
            $project_source_id = $project_sources->insert_project_source(
                [
                    'source_name' => $account_details['others']
                ]
            ); 
        }
        else {
            $project_source_id = $account_details['selected_project_source'];
        }
        // End of project source

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
       
        $customer_id = $customer->insert_customer($customer_attrs,$customer_values);
       
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
            $customer_affiliates->delete_affiliate($customer_id);
        }

        $customer_affiliates->insert_affiliates($affiliate_params);
        // End of affiliates

        // Project Details
        $project_params = [
            'customer_id'           => $customer_id,
            'dealer_id'             => session('user')['customer_id'],
            'project_source_id'     => $project_source_id,
            'vehicle_type'          => $request['vehicleType'],
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'email'                 => $contact_details['email_address'],
            'facebook_url'          => $contact_details['facebook_url'],
            'website_url'           => $contact_details['website_url'],
            'bid_ref_no'            => $account_details['bid_ref_no'],
            'bid_docs_amount'       => $account_details['bid_docs_amount'],
            'pre_bid_sched'         => $account_details['pre_bid_sched'],
            'bid_date_sched'        => $account_details['bid_date_sched'],
            'bidding_venue'         => $account_details['bidding_venue'],
            'approved_budget_cost'  => $account_details['approved_budget_cost'],
            'competitor_flag'       => $request['competitor_flag'],
            'competitor_remarks'    => $request['no_competitor_reason'],
            'status'                => 3 // default status (NEW)
        ];

        $project_id = $project->insert_project($project_params);
        // End of project details

        // Project Contact Number
        $customer_contacts = $contact_details['custContacts'];
        $cust_contact_params = [];
        foreach($customer_contacts as $row){
            $arr = [
                'project_id'           => $project_id,
                'contact_number' => $row['contact_number']
            ];
            array_push($cust_contact_params,$arr);
        }

        $customer_contact->insert_contact($cust_contact_params);
        // End of Project Contact number

        // Project contact persons
        $contact_persons = $contact_details['contactPersons'];
        $contact_person_params = [];
        foreach($contact_persons as $row){
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

        $m_contact_person->insert_contact_persons($contact_person_params);
        // End of contact persons

        // Sales Persons
        $sales_persons = $contact_details['salesPersons'];
        $sales_persons_params = [];
        foreach ($sales_persons as $row) {
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

        $m_sales_persons->insert_sales_person($sales_persons_params);
        // End of sales persons

        // Requirements
        $requirements = $request['requirement'];
      
        foreach ($requirements as $row) {
            $params = [
                'project_id'            => $project_id,
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

            $requirement_id = $m_requirement->insert_requirement($params);

            foreach($row['delivery_schedule'] as $sched){
                $sched_params = [
                    'requirement_id'        => $requirement_id,
                    'quantity'              => $sched['quantity'],
                    'delivery_date'         => $sched['delivery_date'],
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id']
                ];
                $m_delivery_sched->insert_delivery_schedule($sched_params);
            }
        }
        // End of requirements

        // Competitor
        $competitors = $request['competitors'];
        $competitor_params = [];
        foreach ($competitors as $row) {
            $temp = [
                'project_id'            => $project_id,
                'brand'                 => $row['brand'],
                'model'                 => $row['model'],
                'price'                 => $row['price'],
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id']
            ];
            array_push($competitor_params,$temp);
        }
        $m_competitor->insert_competitor($competitor_params);
        // End of competitor

        // Approval
        // approver of dealers
        $approvers = $m_approver->get_project_approvers(session('user')['user_id'],'DLR_MANAGER',$request['vehicleType']);
        $approval_params = [];
        foreach($approvers as $row){
            $temp_arr = [
                'module_id'             => 1, // Fleet Project
                'module_reference_id'   => $project_id,
                'approver_id'           => $row['approver_id'],
                'hierarchy'             => $row['hierarchy'],
                'status'                => 7, // Pending
                'column_reference'      => 'project_id',
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'table_reference'       => 'fs_projects'
            ];
            array_push($approval_params,$temp_arr);
        }
        
        // insert IPC approval
        $ipc_approvers = $m_approver->get_project_approvers(session('user')['user_id'],'IPC_STAFF',$request['vehicleType']);
        foreach($ipc_approvers as $row){
            $temp_arr = [
                'module_id'             => 1, // Fleet Project
                'module_reference_id'   => $project_id,
                'approver_id'           => $row['approver_id'],
                'hierarchy'             => $row['hierarchy'],
                'status'                => 7, // Pending
                'column_reference'      => 'project_id',
                'created_by'            => session('user')['user_id'],
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => session('user')['source_id'],
                'table_reference'       => 'fs_projects'
            ];
            array_push($approval_params,$temp_arr);
        }

        // insert approval
        $m_module_approval->insert_module_approval($approval_params);
        // End of approval

        // Activity Logs
        $activity_log_params = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => 'Fleet project ' . $account_details['account_name'] . ' has been created.',
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'reference_id' => $project_id,
            'reference_column' => 'project_id',
            'reference_table' => 'fs_projects',
            'mail_flag' => 'Y',
            'is_sent_flag' => 'N',
            'mail_recepient' => 'paul-alcabasa@isuzuphil.com;paulalcabasa@gmail.com'
        ];

        $m_activity_logs->insert_log($activity_log_params);
        // End of activity logs

        return response()->json(
            [
                'status' => "success",
                'project_id' => $project_id,
                'customer_id' => $customer_id
            ]
        );
    }

    public function upload_project_attachment(Request $request, Attachment $m_attachment){
        $attachment = $request->attachment;
        $project_id = $request->project_id;
        $customer_id = $request->customer_id;
        $attachment_params = [];
        if(!empty($_FILES)){
            // if new attachment has been placed, delete the old data.
            $m_attachment->delete_attachment($customer_id);
            foreach($attachment as $file){
                //Move Uploaded File

                $destinationPath = 'storage/app/attachments';
                $filename = Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                $orig_filename = $file->getClientOriginalName();
                $temp = [
                    'filename'              => $filename,
                    'directory'             => $destinationPath,
                    'module_id'             => 1, // Fleet project
                    'reference_id'          => $customer_id,
                    'reference_table'       => 'fs_customers',
                    'reference_column'      => 'customer_id',
                    'created_by'            => session('user')['user_id'],
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => session('user')['source_id'],
                    'orig_filename'         => $orig_filename
                ];         
                array_push($attachment_params,$temp);
                $file->move($destinationPath,$filename);
            }
            $m_attachment->insert_attachment($attachment_params);
        }
        return response()->json(
            [
                'status' => "success",
                'project_id' => $project_id
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

    public function save_approval(Request $request, ModuleApproval $m_approval, Project $m_project){
        $project_id = $request->projectId;
        $approval_id = $request->approvalId;
        $remarks = $request->remarks;
        $status  = $request->status;

        $status_id = 0;

        if($status == "approve"){
            $status_id = 4; // approve
        }
        else {
            $status_id = 5; // reject
        }
        
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

        // count pending approval for dealers
        $pending_approval = $m_approval->get_pending_per_project($project_id,'DLR_MANAGER');
    
        // if there is no pending approval amount dealers, set project status to For IPC Review
        if(count($pending_approval) == 0){
          
            $m_project->update_status(
                $project_id,
                11, // update status to Submitted
                session('user')['user_id'],
                session('user')['source_id']
            );
        }

        // count pending approval for ipc
        $ipc_pending_approval = $m_approval->get_pending_per_project($project_id,'IPC_STAFF');
        // if there is no pending approval for IPC, set project status to approved
        if(count($ipc_pending_approval) == 0){
          
            $m_project->update_status(
                $project_id,
                10, // update status Acknowledged
                session('user')['user_id'],
                session('user')['source_id']
            );
        }
    }

    public function ajax_get_delivery_detail(Request $request, ProjectDeliverySchedule $m_delivery_sched){
        $requirement_id = $request->requirement_id;
        $delivery_sched = $m_delivery_sched->get_delivery_schedule($requirement_id);
        return $delivery_sched;
        //return ["data" => 'test'];
    }


}
