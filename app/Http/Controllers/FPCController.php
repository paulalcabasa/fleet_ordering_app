<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\FPC;
use Carbon\Carbon;
use App\Helpers\VehicleTypeIdentification;
use App\Models\FPC_Project;
use App\Models\FPC_Item;
use DB; 

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
            $conflicts = $fpc->getConflictRequirements($projectArr,$vehicle_type);
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

    public function addProject(Request $request){
         // insert fpc projects
        $project_params = [];
        $m_fpc_project = new FPC_Project;
        $m_fpc_item = new FPC_Item;

        $fpc_id = $request->fpcId;
        $projects = $request->projects;

        $project_params = [];

        DB::beginTransaction();
        
        try {

            foreach($projects as $project){
                $project_params = [
                    'fpc_id'                => $fpc_id,
                    'project_id'            => $project['project_id'],
                    'requirement_header_id' => $project['requirement_header_id'],
                    'status'                => 12, // in progress
                    'created_by'            => session('user')['user_id'],
                    'create_user_source_id' => session('user')['source_id'],
                    'creation_date'         => Carbon::now()
                ];
                //array_push($project_params,$temp_arr);
                $fpc_project_id = $m_fpc_project->insert_fpc_project($project_params);
                $requirements = $m_fpc_item->get_fpc_item_requirements($fpc_project_id);
                $item_params = [];
                foreach($requirements as $item){
                    $arr = [
                        'fpc_project_id'         => $item->fpc_project_id,
                        'requirement_line_id'    => $item->requirement_line_id,
                        'suggested_retail_price' => 0, //$item->price,
                        'wholesale_price'        => 0, //$item->price,
                        'fleet_price'            => 0, //$item->price,
                        'dealers_margin'         => 0, // default to 6 but should be from lookup,
                        'lto_registration'       => 0, // default to 10500 but should be from lookup
                        'created_by'             => session('user')['user_id'],
                        'create_user_source_id'  => session('user')['source_id'],
                        'creation_date'          => Carbon::now()
                    ];
                    array_push($item_params,$arr);
                }
                $m_fpc_item->insert_fpc_item($item_params);
            }
        
            DB::commit();
            return response()->json([
                'status' => "FPC has been created!"
            ]);

        } catch(\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

}
