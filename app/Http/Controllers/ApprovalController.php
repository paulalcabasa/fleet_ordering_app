<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModuleApproval;

class ApprovalController extends Controller
{
    //
    public function ajax_get_approval_workflow(Request $request, ModuleApproval $m_approval){
        $project_id = $request->project_id;
        $approval = $m_approval->get_project_approval_workflow($project_id);
        return $approval;
    }
}
