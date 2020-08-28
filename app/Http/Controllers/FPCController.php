<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\FPC;
use Carbon\Carbon;
use App\Helpers\VehicleTypeIdentification;
use App\Models\FPC_Project;
use App\Models\FPC_Item;
use App\Models\ModuleApproval;
use App\Models\ActivityLogs;
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

    public function approve(Request $request){
        DB::beginTransaction();
        try{

       
            // set module approval as approved 
            $moduleApproval = ModuleApproval::findOrFail($request->approval_id);
            
            $maxHierarchy = ModuleApproval::where([
                ['module_reference_id', $moduleApproval->module_reference_id],
                ['module_id' , 3],
            ])->max('hierarchy');
            
            if($moduleApproval->status == 4 || $moduleApproval->status == 5){
                $status = $moduleApproval->status == 4 ? 'approved' : 'rejected';
                $data = [
                    'approval_id' => $request->approval_id,
                    'state'       => 'approve',
                    'message'     => 'It seems that you have already '.$status.' the FPC No. <strong>' . $moduleApproval->module_reference_id . '</strong>',
                    'image_url'   => url('/') . '/public/img/approval-error.jpg'
                ];
                return view('mail.message', $data);
            }

            $moduleApproval->status = 4;
            $moduleApproval->date_approved = Carbon::now();
            $moduleApproval->updated_by = -1;
            $moduleApproval->update_user_source_id = -1;
            $moduleApproval->save();

            // update next hierarchy
            $fpc = FPC::findOrFail($moduleApproval->module_reference_id);
            $current = (int) $fpc->current_approval_hierarchy;
            $fpc->current_approval_hierarchy = $current + 1;
            // check if this is the last approver
            if($moduleApproval->hierarchy == $maxHierarchy){
                $fpc->status = 4;    
                
                // notify ipc staff and dealer that fpc is approved
                $activity_log = new ActivityLogs;
                $fpc_detail = new FPC;
                $fpc_details = $fpc_detail->get_details($moduleApproval->module_reference_id);
                $activity_log_params = [
                    'module_id'             => 3, // Fleet Project
                    'module_code'           => 'FPC',
                    'content'               => 'Your FPC No. ' . $moduleApproval->module_reference_id . ' has been approved!',
                    'created_by'            => -1,
                    'creation_date'         => Carbon::now(),
                    'create_user_source_id' => -1,
                    'reference_id'          => $moduleApproval->module_reference_id,
                    'reference_column'      => 'fpc_id',
                    'reference_table'       => 'fs_fpc',
                    'mail_flag'             => 'Y',
                    'is_sent_flag'          => 'N',
                    'timeline_flag'         => 'Y',
                    'mail_recipient'        => $fpc_details->requestor_email
                ];

                $activity_log->insert_log($activity_log_params);
            }
            $fpc->save();

            

            DB::commit();

            // if current hierarchy is equal to the max hierarchy 
            // set fpc status to approved
            $data = [
                'approval_id' => $request->approval_id,
                'state'       => 'approve',
                'fpc_id'      => 'the fpc _id',
                'message'     => 'You have successfully approved FPC No. <strong>' . $moduleApproval->module_reference_id . '</strong>!',
                'image_url'   => url('/') . '/public/img/approval-success.gif'
            ];
            return view('mail.message', $data);
            
        } catch(Exception $e){
            return [
                'message' => 'An error occured!'
            ];
            DB::rollBack();
        }
        


        
    }

    public function reject(Request $request){

        // set module approval as approved 
        $moduleApproval = ModuleApproval::findOrFail($request->approval_id);
        
        if($moduleApproval->status == 5 || $moduleApproval->status  == 4){
            $status = $moduleApproval->status == 4 ? 'approved' : 'rejected';
            $data = [
                'approval_id' => $request->approval_id,
                'state'       => 'reject',
                'message'     => 'It seems that you have already '. $status .' the FPC No. <strong>' . $moduleApproval->module_reference_id . '</strong>',
                'image_url'   => url('/') . '/public/img/approval-error.jpg'
            ];
            return view('mail.message', $data);
        }

        $moduleApproval->status = 4;
        $moduleApproval->date_approved = Carbon::now();
        $moduleApproval->updated_by = -1;
        $moduleApproval->update_user_source_id = -1;
        $moduleApproval->save();

        $data = [
            'approval_id' => $request->approval_id,
            'reject_api'      => url('/') . '/api/fpc/reject-fpc/' . $request->approval_id
        ];
        return view('mail.form-reject', $data);
    }

    public function processReject(Request $request){

        
        DB::beginTransaction();
        try {
            $moduleApproval = ModuleApproval::findOrFail($request->approval_id);
            $moduleApproval->status = 5; // rejected
            $moduleApproval->remarks = $request->remarks;
            $moduleApproval->date_approved = Carbon::now();
            $moduleApproval->updated_by = -1;
            $moduleApproval->update_user_source_id = -1;
            $moduleApproval->save();

            $fpc = FPC::findOrFail($moduleApproval->module_reference_id);
            $fpc->status = 12; // rejected;
            $fpc->save();

            $fpc_detail = new FPC;
            $fpc_details = $fpc_detail->get_details($moduleApproval->module_reference_id);

            $activity_log = new ActivityLogs;
            $activity_log_params = [
                'module_id'             => 3, // Fleet Project
                'module_code'           => 'FPC',
                'content'               => 'Your FPC No. ' . $moduleApproval->module_reference_id . ' has been rejected!',
                'created_by'            => -1,
                'creation_date'         => Carbon::now(),
                'create_user_source_id' => -1,
                'reference_id'          => $moduleApproval->module_reference_id,
                'reference_column'      => 'fpc_id',
                'reference_table'       => 'fs_fpc',
                'mail_flag'             => 'Y',
                'is_sent_flag'          => 'N',
                'timeline_flag'         => 'Y',
                'mail_recipient'        => $fpc_details->requestor_email
            ];
            $activity_log->insert_log($activity_log_params);


            DB::commit();

            $data = [
                'approval_id' => $request->approval_id,
                'state'       => 'reject',
                'message'     => 'You have successfully rejected FPC No. <strong>' . $moduleApproval->module_reference_id . '</strong>!',
                'image_url'   => url('/') . '/public/img/approval-success.gif'
            ];
            return view('mail.message', $data);

        } catch(Exception $e){
            DB::rollBack();
        }
    }

}
