<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesPersons;

class SalesPersonController extends Controller
{
    public function get_sales_person_detail(Request $request, SalesPersons $sales_person){
    	$sales_person_id = $request->sales_person_id;
    	$data = $sales_person->get_sales_person_details($sales_person_id)[0];
    	return response()->json(['data' => $data]);
    }
}
