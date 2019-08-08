<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FWPC;
use App\Models\SalesOrderLines;
use Carbon\Carbon;
class FWPCController extends Controller
{
    public function add_fwpc(Request $request, FWPC $m_fwpc){
        $params = [
            'project_id'            => $request->project_id,
            'sales_order_header_id' => $request->sales_order_id,
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id']
        ];
        $fwpc_id = $m_fwpc->insert_fwpc($params);
        $data = $m_fwpc->get_fwpc_by_id($fwpc_id);
        return response()->json($data);
    }

    public function get_fwpc_list(Request $request){
        return response()->json($m_fwpc->get_fwpc_by_project($request->project_id));
    }

    public function destroy(Request $request, FWPC $m_fwpc){
        $fwpc_id = $request->fwpc_id;
        $query = $m_fwpc->delete_fwpc($fwpc_id);
        return $query;
    }

    
}
