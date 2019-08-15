<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;
use App\Models\FWPC;
use App\Models\SalesOrderLines;
use App\Models\FPC_Project;
use Carbon\Carbon;
use App\Models\SalesPersonsOra;
use App\Models\ActivityLogs;
use App\Models\Project;

class FWPCController extends Controller
{
    public function add_fwpc(
        Request $request, 
        FWPC $m_fwpc,
        ActivityLogs $m_activity_logs,
        Project $m_project
    ){
        $params = [
            'project_id'            => $request->project_id,
            'sales_order_header_id' => $request->sales_order_id,
            'fpc_project_id'        => $request->fpc_project_id, 
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id']
        ];
        $fwpc_id         = $m_fwpc->insert_fwpc($params);
        $data            = $m_fwpc->get_fwpc_by_id($fwpc_id);
        $project_details = $m_project->get_details($request->project_id);

        $activity_log = [
            'module_id'             => 1, // Fleet Project
            'module_code'           => 'PRJ',
            'content'               => session('user')['first_name'] . ' ' . session('user')['last_name'] . ' has created an FPWC for Project No. <strong>'.$request->project_id.'</strong>.',
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
            'reference_id'          => $request->project_id,
            'reference_column'      => 'project_id',
            'reference_table'       => 'fs_projects',
            'mail_flag'             => 'Y',
            'is_sent_flag'          => 'N',
            'timeline_flag'         => 'Y',
            'mail_recipient'        => $project_details->requestor_email
        ];
        $m_activity_logs->insert_log($activity_log);
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

    public function print_fwpc(
        Request $request,
        FWPC $m_fwpc,
        FPC_Project $m_fpc_project,
        SalesPersonsOra $m_sales_persons,
        SalesOrderLines $m_sol
    ){
        $fwpc_id = $request->fwpc_id;
        $fwpc_details = $m_fwpc->get_fwpc_by_id($fwpc_id);
        $sales_persons = $m_sales_persons->get_sales_persons($fwpc_details->project_id);
        $so_lines = $m_sol->get_fwpc_lines($fwpc_details->fpc_project_id);

        $wht_tax = 0;
        $grand_total = 0;
        foreach($so_lines as $row){
            $grand_total += ($row->fleet_price - $row->dealer_margin - $row->lto_registration) * $row->quantity;
        }

        $wht_tax = ($grand_total / 1.12) * 0.01;
        $check_amount = $grand_total - $wht_tax;
        $data = [
            'fwpc_details'  => $fwpc_details,
            'sales_persons' => $sales_persons,
            'so_lines'      => $so_lines,
            'wht_tax'       => $wht_tax,
            'check_amount'  => $check_amount
        ];


        $pdf = PDF::loadView('pdf.print_fwpc', $data);
        return $pdf->setPaper('a4','portrait')->stream();

    }    
}
