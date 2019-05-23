<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    //

    public function all_customers(){
    	return view('customer.all_customer');
    }

    public function manage_customer(Request $request, Customer $customer){
    	$action = $request->action;
    	$customer_id = $request->customer_id;
    	$scope_of_business = $customer->get_scope_of_business('test');
    	$scope_of_business = json_decode(json_encode($scope_of_business), true);
    	$scope_of_business = array_column($scope_of_business,'class_code_description');
    	$page_data = array(
    		'action' => $action,
    		'customer_id' => $customer_id,
    		'scope_of_business' => $scope_of_business
    	);
    	return view('customer.manage_customer',$page_data);
    }

    public function ajax_get_scope(Request $request, Customer $customer){
        $scope_of_business_name = $request->q;
        $arr = array();
        $scope_of_business = $customer->get_scope_of_business($scope_of_business_name);
        foreach($scope_of_business as $s){
            $row_array = array(
                'id'=>$s->class_code,
                'text' => $s->class_code_description
            );
            array_push($arr,$row_array);
        }
        //$scope_of_business = json_decode(json_encode($scope_of_business), true);
        //$scope_of_business = array_column($scope_of_business,'class_code_description');
        return json_encode($arr);
    }

    

}
