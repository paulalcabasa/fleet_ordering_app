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

    public function approval_list(ModuleApproval $m_approval){
        $project_approval_list = $m_approval->get_projects_approval(
            session('user')['customer_id'],
            session('user')['user_id'],
            session('user')['source_id'],
            session('user')['user_type_id']
        );


        $po_approval_list = $m_approval->get_po_approval(
            session('user')['user_id'],
            session('user')['source_id']
        );

        $approval_list = array_merge($project_approval_list, $po_approval_list);



        $page_data = [
            'approval_list' => $approval_list,
            'base_url'      => url('/'),
            'status_colors' => config('app.status_colors')
        ];
        return view('approval_list',$page_data); 
    }

}
