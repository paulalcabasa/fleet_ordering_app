<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function manage_po(Request $request){
    	
    	$page_data = [
    		'price_confirmation_id' => $request->price_confirmation_id,
            'action' => $request->action
    	];

    	return view('purchase_order.manage_po', $page_data);
    }

    public function all_po(){
    	return view('purchase_order.all_po');
    }

}
