<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrganizationTypes;
use App\ProjectSources;
use App\Customer;
use App\SalesPersons;

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

        $organizations = $org_types->get_org_options();
        $project_sources = $project_sources->get_project_sources_options();
        $customer_options = $customer->get_customer_options();
        $customer_names = $customer->get_customer_names();
        $customer_names = array_column($customer_names,'customer_name');
        $sales_persons = $sales_person->get_sales_persons(session('user')['customer_id']);

    	$price_confirmation_id = $request->price_confirmation_id;
    	$action = $request->action;
    	
    	$page_data = array(
    		'price_confirmation_id' => $price_confirmation_id,
    		'action' => $action,
            'organizations' => $organizations,
            'project_sources' => $project_sources,
            'customer_options' => $customer_options,
            'customer_names' => $customer_names,
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
}
