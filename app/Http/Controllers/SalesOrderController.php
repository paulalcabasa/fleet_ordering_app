<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrderHeader;
use App\Models\SalesOrderLines;

class SalesOrderController extends Controller
{
    public function get_so_details(Request $request, SalesOrderHeader $m_soh){
        $sales_order_no = $request->sales_order_number;
        $dealer_id = $request->dealer_id;
        $header_details = $m_soh->get_so_headers($sales_order_no, $dealer_id);
        return ['header_data' => $header_details];//$header_details;
    }

    public function sales_order_data(
        Request $request, 
        SalesOrderHeader $m_soh, 
        SalesOrderLines $m_sol
    ){
        $fwpc_id = $request->fwpc_id;
        $so_header = $m_soh->get_so_data_by_id($fwpc_id);
        $so_lines = $m_sol->get_so_lines($fwpc_id);
        return [
            'so_header' => $so_header,
            'so_lines' => $so_lines
        ];
    }
}
