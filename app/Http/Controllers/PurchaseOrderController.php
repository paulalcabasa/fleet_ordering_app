<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function po_entry(Request $request){
    	
    	$page_data = [
    		'price_confirmation_id' => $request->price_confirmation_id
    	];

    	return view('purchase_order.po_entry', $page_data);
    }

    public function all_po(){
    	return view('purchase_order.all_po');
    }

}
