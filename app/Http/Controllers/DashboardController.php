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
      
        if(!in_array(session('user')['user_type_id'], array(25,27,31,32,33,38)) ){
            return view('errors.404');
        }

        // if sales invoicing user, redirect to FWPC Listing
        if(session('user')['user_type_id'] == 38){
            return redirect()->route('fwpc_list');
        }
    
        switch(session('user')['user_type_id']){
            case 27 : // dealer staff 

                $project_ctr = $m_project->countProjects([
                    ['fp.dealer_id' , session('user')['customer_id']],
                    ['fp.created_by', session('user')['user_id']],
                    ['fp.create_user_source_id', session('user')['source_id']],
                ]);

                $open_project_ctr = $m_project->countProjects([
                    ['fp.dealer_id' , session('user')['customer_id']],
                    ['fp.created_by', session('user')['user_id']],
                    ['fp.create_user_source_id', session('user')['source_id']],
                    ['fp.status', '<>', 13], // not closed
                    ['fp.status', '<>', 6], // not cancelled
                ]);

                $pending_fpc_projects = $m_project->countPendingFPC([
                    ['fp.dealer_id' , session('user')['customer_id']],
                    ['fp.created_by', session('user')['user_id']],
                    ['fp.create_user_source_id', session('user')['source_id']],
                    ['fp.status', 11 ]
                ]);

                $purchase_orders = $m_poh->countPO([
                    ['fp.dealer_id' , session('user')['customer_id']],
                    ['fp.created_by', session('user')['user_id']],
                    ['fp.create_user_source_id', session('user')['source_id']],
                ]);

                $recent_activities = $m_logs->getRecentActivities([
                    ['fp.dealer_id' , session('user')['customer_id']],
                    ['fp.created_by', session('user')['user_id']],
                    ['fp.create_user_source_id', session('user')['source_id']],
                ]);

                $project_ctr_year = $m_project->countProjectsYearly(
                    [
                        ['fp.dealer_id' , session('user')['customer_id']],
                        ['fp.created_by', session('user')['user_id']],
                        ['fp.create_user_source_id', session('user')['source_id']],
                    ],
                    'extract(year from fp.creation_date) = ' . date('Y')
                );
            

            break;
            case 31 :  // dealer manager
                $project_ctr = $m_project->countProjects([
                    ['fp.dealer_id' , session('user')['customer_id']],
                ]);   

                $open_project_ctr = $m_project->countProjects([
                    ['fp.dealer_id' , session('user')['customer_id']],
                    ['fp.status', '<>', 13], // not closed
                    ['fp.status', '<>', 6], // not cancelled
                ]);  

                $pending_fpc_projects = $m_project->countPendingFPC([
                    ['fp.dealer_id' , session('user')['customer_id']],
                    ['fp.status', 11 ]
                ]);

                $purchase_orders = $m_poh->countPO([
                    ['fp.dealer_id' , session('user')['customer_id']]
                ]);

                $recent_activities = $m_logs->getRecentActivities([
                    ['fp.dealer_id' , session('user')['customer_id']]
                ]);

                $project_ctr_year = $m_project->countProjectsYearly(
                    [
                        ['fp.dealer_id' , session('user')['customer_id']]
                    ],
                    'extract(year from fp.creation_date) = ' . date('Y')
                );


            break;
            case 32 :  // lcv user 
                $project_ctr = $m_project->countProjects([
                    ['rh.vehicle_type', 'LCV']
                ]);
                
                $open_project_ctr = $m_project->countProjects([
                    ['rh.vehicle_type', 'LCV'],
                    ['fp.status', '<>', 13], // not closed
                    ['fp.status', '<>', 6], // not cancelled
                ]);

                $pending_fpc_projects = $m_project->countPendingFPC([
                    ['rh.vehicle_type', 'LCV'],
                    ['fp.status', 11 ]
                ]);

                $purchase_orders = $m_poh->countPO([
                    ['rh.vehicle_type', 'LCV'],
                ]);

                $recent_activities = $m_logs->getRecentActivities([]);

                $project_ctr_year = $m_project->countProjectsYearly(
                    [
                        ['fp.dealer_id' , session('user')['customer_id']],
                        ['rh.vehicle_type', 'LCV'],
                    ],
                    'extract(year from fp.creation_date) = ' . date('Y')
                );

            break;
            case 33 :  // cv user 
                $project_ctr = $m_project->countProjects([
                    ['rh.vehicle_type', 'CV']
                ]);

                $open_project_ctr = $m_project->countProjects([
                    ['rh.vehicle_type', 'CV'],
                    ['fp.status', '<>', 13], // not closed
                    ['fp.status', '<>', 6], // not cancelled
                ]);

                $pending_fpc_projects = $m_project->countPendingFPC([
                    ['rh.vehicle_type', 'CV'],
                    ['fp.status', 11 ]
                ]);

                $purchase_orders = $m_poh->countPO([
                    ['rh.vehicle_type', 'CV'],
                ]);
                
                $recent_activities = $m_logs->getRecentActivities([]);
                
                $project_ctr_year = $m_project->countProjectsYearly(
                    [
                        ['fp.dealer_id' , session('user')['customer_id']],
                        ['rh.vehicle_type', 'CV'],
                    ],
                    'extract(year from fp.creation_date) = ' . date('Y')
                );

            break;
             
        }
        
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
            'annual_fleet_reg'     => $project_ctr_year[0],
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
