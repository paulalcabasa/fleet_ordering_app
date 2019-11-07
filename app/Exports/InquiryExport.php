<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Reports;

class InquiryExport implements FromView
{

    protected $params;
    protected $m_reports;

    public function __construct($params){
        $this->params = $params;
        $this->m_reports = new Reports();
    } 
    
    public function view(): View {
        $inquiries = $this->m_reports->get_inquiry_history($this->params);
        return view('reports.exports.inquiry_history', [
            'inquiries' => $inquiries
        ]);
    }
}
