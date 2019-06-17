<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrganizationTypes;
use App\ProjectSources;
use App\Customer;
use App\SalesPersons;
use App\VehicleType;
use App\CustomerAffiliates;
use Carbon\Carbon;
use App\Project;
use App\CustomerContact;
use App\ContactPersons;
use App\SalesPersonsOra;
use App\ProjectRequirement;
use App\ProjectDeliverySchedule;
use App\Competitor;

class ProjectController extends Controller
{
    //

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
        $customer_names   = $customer->get_customer_names();
        $customer_names   = array_column($customer_names,'customer_name');
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
            'customer_names'   => $customer_names,
            'sales_persons'    => $sales_persons,
            'vehicle_types'    => $vehicle_types
    	);
    	return view('projects.manage_project', $page_data);
    }

    public function all_projects(){
    	return view('projects.all_projects');
    }

    public function project_overview(Request $request){

        $po = [];
        
        $page_data = [
            'project_id' => $request->project_id,
            'action' => $request->action
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
        Competitor $m_competitor

    ){
        ini_set('memory_limit', '256M');
        $form_data = $request->data;

        $account_details = $form_data['accountDetails'];
        $contact_details = $form_data['contactDetails'];
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
        $customer_params = [
            'organization_type_id'  => $account_details['selected_org_type'],
            'customer_name'         => $account_details['account_name'],
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
        $customer_id = $customer->insert_customer($customer_params);
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

        $customer_affiliates->insert_affiliates($affiliate_params);
        // End of affiliates

        // Project Details
        $project_params = [
            'customer_id'           => $customer_id,
            'dealer_id'             => session('user')['customer_id'],
            'project_source_id'     => $account_details['selected_project_source'],
            'vehicle_type'          => $form_data['vehicleType'],
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
            'competitor_flag'       => $form_data['competitor_flag'],
            'competitor_remarks'    => $form_data['no_competitor_reason']
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
                'project_id' => $project_id,
                'name' => $row['name'],
                'position_title' => $row['position'],
                'department' => $row['department'],
                'contact_number' => $row['contact_number'],
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
        $requirements = $form_data['requirement'];
      
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
        $competitors = $form_data['competitors'];
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
        return response()->json(['data' => $competitor_params]);
     
    }
}
