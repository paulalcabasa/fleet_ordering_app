<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ActivityLogs;
use App\Models\POHeaders;
class DashboardController extends Controller
{
    public function dashboard(
        Project $m_project,
        ActivityLogs $m_logs,
        POHeaders $m_poh
    ){
    
        // if sales invoicing user, redirect to FWPC Listing
        if(session('user')['user_type_id'] == 38){
            return redirect()->route('fwpc_list');
        }


        $project_ctr = $m_project->count_all_projects(
            session('user')['user_type_id'],
            session('user')['customer_id']
        );

        $open_project_ctr = $m_project->count_open_projects(
            session('user')['user_type_id'],
            session('user')['customer_id']
        );

        $pending_fpc_projects = $m_project->count_pending_fpc_projects(
            session('user')['user_type_id'],
            session('user')['customer_id']
        );

        $purchase_orders = $m_poh->count_all_po(
            session('user')['user_type_id'],
            session('user')['customer_id']
        );
        
        $recent_activities = $m_logs->get_recent_activities(
            session('user')['user_type_id'],
            session('user')['customer_id']
        );

        $project_ctr_year = $m_project->count_projects_yearly(
            session('user')['user_type_id'],
            session('user')['customer_id'],
            date('Y')
        );
        
        $last_day = date("t", strtotime(date('Y-m-d')));
        
        $monthly_projects = $m_project->count_projects_monthly(
            $last_day, 
            date('m'), 
            date('Y'), 
            session('user')['user_type_id'],
            session('user')['customer_id']
        );  

        $mp_flat = [];

        $index = 0;
        foreach($monthly_projects as $key => $value){
            $mp_flat[$index] =  $value + rand(1,20);
            $index++;
        }

        $month_name = date('F');
        $year = date('Y');

        $page_data = [
            'project_ctr'          => $project_ctr,
            'recent_activities'    => $recent_activities,
            'project_ctr_year'     => $project_ctr_year,
            'open_project_ctr'     => $open_project_ctr,
            'pending_fpc_projects' => $pending_fpc_projects,
            'purchase_orders'      => $purchase_orders,
            'last_day'             => $last_day,
            'monthly_projects'     => $mp_flat,
            'month_name'           => $month_name,
            'year'                 => $year
        ];
    
        return view('dashboard', ($page_data));
    }
}
