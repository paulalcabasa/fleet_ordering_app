<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //

    public function manage_project(Request $request){
    	$price_confirmation_id = $request->price_confirmation_id;
    	$action = $request->action;
    	
    	$page_data = array(
    		'price_confirmation_id' => $price_confirmation_id,
    		'action' => $action
    	);
    	return view('projects.manage_project', $page_data);
    }

    public function all_projects(){
    	return view('projects.all_projects');
    }

    public function project_overview(Request $request){

        $po = [];
        
        $page_data = [
            'project_id' => $request->project_id
        ];
        return view('projects.project_overview', $page_data);
    }
}
