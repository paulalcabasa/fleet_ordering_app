<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InquiryExport;


class ReportsController extends Controller
{
  
    public function export_inquiry_history(Request $request){
        $params = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];
        return Excel::download(new InquiryExport($params), 'inquiry_history.xlsx');
    }
}
