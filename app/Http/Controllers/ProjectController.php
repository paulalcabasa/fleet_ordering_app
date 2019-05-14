<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //

    public function new_project(){
    	return view('projects.new_project');
    }

    public function all_projects(){
    	return view('projects.all_projects');
    }
}
