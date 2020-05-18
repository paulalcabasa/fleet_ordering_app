<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InquiryExport;
use App\Exports\FPCSummaryExport;
use App\Models\Reports;


class ReportsController extends Controller
{
  
    public function export_inquiry_history(Request $request){
        $params = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];
        return Excel::download(new InquiryExport($params), 'inquiry_history.xlsx');
    }

    public function showTaggedUnits(){
      
        $reports = new Reports();
        $tagged = $reports->getTaggedUnits();
    	$page_data = array(
    		'taggedUnits'           => $tagged,
            'base_url'             => url('/'),
    	);
    	return view('reports.tagged_units', $page_data);
    }

    public function showInvoices(Request $request){
        $reports = new Reports();
        $params = [
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date
        ];
        $invoices = $reports->getInvoices($params);
        return response()->json($invoices);
    }

     public function export_fpc_summary(Request $request){
        $params = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];
        return Excel::download(new FPCSummaryExport($params), 'fpc_summary.xlsx');
    }
}
