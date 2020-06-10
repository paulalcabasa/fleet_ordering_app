<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Attachment;
use App\Models\CustomerAffiliates;

class CustomerController extends Controller
{
    //

    private $customer;
    private $affiliate;
    private $attachment;

    public function __construct(){
        $this->customer = new Customer();
        $this->affiliate = new CustomerAffiliates();
        $this->attachment = new Attachment();
    }
    public function all_customers(Customer $m_customer){
        $dealer_id = session('user')['customer_id'];
        $user_type = session('user')['user_type_name'];
        $all_customers = $m_customer->get_all_customers($user_type,$dealer_id);
        $page_data = [
            'all_customers' => $all_customers,
            'base_url' => url('/')
        ];
    	return view('customer.all_customer', $page_data);
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
        $query = $request->all();
        $scope_of_business = $customer->get_scope_of_business($query['query']);
       /* foreach($scope_of_business as $s){
            $row_array = array(
                'id'=>$s->class_code_description,
                'text' => $s->class_code_description
            );
            array_push($arr,$row_array);
        }*/
        $scope_of_business = json_decode(json_encode($scope_of_business), true);
        $scope_of_business = array_column($scope_of_business,'class_code_description');
        return json_encode($scope_of_business);
    }

    public function ajax_get_affiliates(Request $request, Customer $m_customer){
        $query = $request->term;
        return json_encode($query);
        $customers = $m_customer->get_affiliate_options($query);
        $arr = [];
        foreach($customers as $s){
            $row_array = array(
                'id'=>$s->customer_id,
                'text' => $s->customer_name
            );
            array_push($arr,$row_array);
        }
        //$scope_of_business = json_decode(json_encode($scope_of_business), true);
        // $scope_of_business = array_column($scope_of_business,'class_code_description');
        return json_encode($arr);
    }

    public function ajax_get_customer_data(
        Request $request, 
        Customer $m_customer, 
        CustomerAffiliates $m_affiliate,
        Attachment $m_attachment
    ){
        $customer_name = $request->customer_name;
        $details       = $m_customer->get_customer_data($customer_name);
        $affiliates    = $m_affiliate->get_affiliate($details->customer_id);
        $attachments   = $m_attachment->get_attachments($details->customer_id);
        return [
            'details'     => $details,
            'affiliates'  => $affiliates,
            'attachments' => $attachments
        ];
    }

    public function ajax_get_customers(Request $request, Customer $m_customer){
        $query = $request->all();
      
        $customers = $m_customer->get_customers($query['query']);
       /* foreach($scope_of_business as $s){
            $row_array = array(
                'id'=>$s->class_code_description,
                'text' => $s->class_code_description
            );
            array_push($arr,$row_array);
        }*/
        $customers = json_decode(json_encode($customers), true);
        $customers = array_column($customers,'customer_name');
        return json_encode($customers);
    }

    public function get_customers_select2(Request $request, Customer $m_customer){
        $query = $request->all();
        $customers = $m_customer->get_customers_by_project($query['term']);
        return json_encode($customers);
    }
    
    public function customer_overview(Request $request){
        $customer_id      = $request->customer_id;
        $affiliates       = $this->affiliate->get_customer_affiliates($customer_id);
        $attachments      = $this->attachment->get_attachments($customer_id);
        $customer_details = $this->customer->get_customer_details_by_id($customer_id);

        $page_data = array(
            'customer_details' => $customer_details,
            'attachments'      => $attachments,
            'affiliates'       => $affiliates,
            'baseUrl'          => url('/')
        );

        return view('customer.customer_overview',$page_data);
    }

  

    public function get_customer_info(
        Request $request, 
        Customer $m_customer, 
        CustomerAffiliates $m_affiliate,
        Attachment $m_attachment
    ){
        $customer_name = $request->customer_name;
        $details       = $m_customer->get_customer_data($customer_name);
        $affiliates    = $m_affiliate->get_affiliate($details->customer_id);
        $attachments   = $m_attachment->get_attachments($details->customer_id);
        return [
            'details'     => $details,
            'affiliates'  => $affiliates,
            'attachments' => $attachments
        ];
    }

}
