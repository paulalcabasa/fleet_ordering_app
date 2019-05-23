<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PriceConfirmationController extends Controller
{
    public function all_price_confirmation(){
    	return view('price_confirmation.all_price_confirmation');
    }

    public function price_confirmation_entry(){
    	return view('price_confirmation.price_confirmation_entry');
    }

    public function price_confirmation_details(Request $request){
    	//$price_confirmation_id = Input::get('price_confirmation_id');
    	$price_confirmation_id = $request->price_confirmation_id;
    	$action = $request->action;
    	$page_data = array(
    		'price_confirmation_id' => $price_confirmation_id,
            'action' => $action
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
}
