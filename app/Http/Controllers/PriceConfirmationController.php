<?php

namespace App\Http\Controllers;

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

class PriceConfirmationController extends Controller
{
    public function all_price_confirmation(FPC $m_fpc){
        $fpc_list = $m_fpc->get_fpc(
            session('user')['user_type_id']
        );

        $page_data = [
            'fpc_list' => $fpc_list,
            'base_url' => url('/')
        ];
    	return view('price_confirmation.all_price_confirmation', $page_data);
    }

    public function price_confirmation_entry(Customer $m_customer){

        $vehicle_type = "";
        if(session('user')['user_type_id'] == 32) { // LCV
            $vehicle_type = "LCV";
        }
        else if(session('user')['user_type_id'] == 33) { // CV
            $vehicle_type = "CV";
        }
        $customers = $m_customer->get_project_customers($vehicle_type);

        $page_data = [
            'customers'    => $customers,
            'vehicle_type' => $vehicle_type,
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
        Competitor $m_competitor
    ){

    	$price_confirmation_id = $request->price_confirmation_id;
    	$action = $request->action;

        $fpc_details = $m_fpc->get_details($price_confirmation_id);
        $customer_details = $m_customer->get_customer_details_by_id($fpc_details->customer_id);
        $project_headers = $m_fpc_project->get_projects($price_confirmation_id);

        $projects = [];

        foreach($project_headers as $project){

            $requirements = $m_fpc_item->get_item_requirements($project->fpc_project_id);
            $competitors = $m_competitor->get_competitors($project->project_id);
            $temp_arr = [
                'project_id' => $project->project_id,
                'dealer_name' => $project->dealer_name,
                'dealer_account' => $project->dealer_account,
                'project_status' => $project->project_status,
                'requirements' => $requirements,
                'competitors' => $competitors
            ];
            array_push($projects,$temp_arr);
        }

    	$page_data = array(
    		'price_confirmation_id' => $price_confirmation_id,
            'action'                => $action,
            'fpc_details'           => $fpc_details,
            'customer_details'      => $customer_details,
            'projects'              => $projects
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
        $vehicle_type = $request->vehicle_type;

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
        $vehicle_type = $request->vehicle_type;
        $projects = $request['projects'];

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
                'fpc_project_id'        => $item->fpc_project_id,
                'requirement_id'        => $item->requirement_id,
                'one_price'             => $item->price,
                'wholesale_price'       => $item->price,
                'fleet_price'           => $item->price,
                'dealers_margin'        => 6, // default to 6 but should be from lookup,
                'lto_registration'      => 10500, // default to 10500 but should be from lookup
                'created_by'            => session('user')['user_id'],
                'create_user_source_id' => session('user')['source_id'],
                'creation_date'         => Carbon::now()
            ];
            array_push($item_params,$arr);
        }

        $m_fpc_item->insert_fpc_item($item_params);
        // end of fpc project items
        return [
            'customer_id' => $customer_id,
            'projects' => $projects
        ];
    }

}
