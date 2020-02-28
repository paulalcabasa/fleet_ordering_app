<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\FPC;
use App\Helpers\VehicleTypeIdentification;

class FPCController extends Controller
{
    
    protected $vehicle_type;

    public function __construct(VehicleTypeIdentification $vehicle_type){
        $this->vehicle_type = $vehicle_type;
    }

    public function getProjects(Request $request){
        $fpc = new FPC;
        $customer_id = $request->customer_id;
        $conflicts = [];
        $vehicle_type = $this->vehicle_type->get_vehicle_type(session('user')['user_type_id']);
        $projectArr = [];
        
       
        $activeFpc = $fpc->getActiveFPC($customer_id,$vehicle_type);
        $projects = $fpc->getProjects($customer_id,$vehicle_type);
        $activeProjects = [];
        if(!empty($activeFpc)){
            $activeProjects = $fpc->getActiveProjects($customer_id,$vehicle_type);
        }
        
        $projects = array_merge($projects,$activeProjects);
        
        foreach($projects as $x){
            array_push($projectArr,$x->project_id);
        }

        $projectArr = implode($projectArr,',');
            if($projectArr != ""){
            $conflicts = $fpc->getConflictRequirements($projectArr);
        }

        // remove projects with fpc already
        $ctr = 0;
        foreach($projects as $key => $value){
            if($value->fpc_id != ""){
                unset($projects[$key]);
            }
        }

       
        return [
            'projects' => $projects,
            'conflicts' => $conflicts,
            'activeFpc' => $activeFpc
        ];
   
    }

    public function getConflictRequirements(Request $request) {
        //projects = $request->projects;
        $fpc = new FPC;
        $conflicts = $fpc->getConflictRequirements('412,413');
        return $conflicts;
    }

}
