<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //

    public function all_customers(){
    	return view('customer.all_customer');
    }

    public function new_customer(){
    	return view('customer.new_customer');
    }
}
