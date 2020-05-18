<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Reports;

class FPCSummaryExport implements FromView
{

    protected $params;
    protected $m_reports;

    public function __construct($params){
        $this->params = $params;
        $this->m_reports = new Reports();
    } 
    
    public function view(): View {
        $fpc = $this->m_reports->get_fpc_summary($this->params);
        return view('reports.exports.fpc_summary', [
            'fpc' => $fpc
        ]);
    }
}
