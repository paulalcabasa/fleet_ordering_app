<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approver;
use App\Models\OracleUser;
use Carbon\Carbon;

class ApproverController extends Controller
{
    
    private $approver;
    private $user;
    public function __construct(){
        $this->approver = new Approver();
        $this->user = new OracleUser();
    }

    public function approver_list(){
        $user_list = $this->user->get_users();
        
        $page_data = array(
            'users'               => $user_list,
            'status_colors'       => config('app.status_colors'),
        );
        
    	return view('approvers.approver_list', $page_data);
    }

    public function get_approvers(){
        $approvers = $this->approver->get_approvers();
        
        $approver_data = [];
        foreach ($approvers as $row) {
            $arr = [
                'status'            => $row->status_id == 1 ? true : false,
                'approver_id'       => $row->approver_id,
                'approver_name'     => $row->approver_name,
                'user_type'         => $row->user_type,
                'vehicle_type'      => $row->vehicle_type,
                'requestor_user_id' => $row->requestor_user_id,
                'approver_user_id'  => $row->approver_user_id,
                'hierarchy'         => $row->hierarchy,
                'email_address'     => $row->email_address,
                'signatory_type'    => $row->signatory_type,
                'position'          => $row->position_title,
            ];
            array_push($approver_data,$arr);
        }

        return $approver_data;
    }

    public function add_approver(Request $request){
    
        $params = [
            'approver_user_id'      => $request->approver_user_id,
            'approver_source_id'    => $request->approver_source_id,
            'vehicle_type'          => $request->vehicle_type,
            'user_type'             => $request->approver_type,
            'signatory_type'        => $request->signatory_type,
            'position_title'        => $request->position,
            'hierarchy'             => 99,
            'status_id'             => 1,
            'module_code'           => 'PRJ',
            'created_by'            => session('user')['user_id'],
            'creation_date'         => Carbon::now(),
            'create_user_source_id' => session('user')['source_id'],
        ];
        $this->approver->add_approver($params);    
    }

    public function update_approver_status(Request $request){

        $status_id = $request->status ? 2 : 1;
        
        $params = [
            'approver_id'           => $request->approver_id,
            'status_id'             => $status_id,
            'updated_by'            => session('user')['user_id'],
            'update_user_source_id' => session('user')['source_id']
        ];       

        $this->approver->update_status($params);
    
    }

    public function update_approver(Request $request){
        $params = [
            'approver_id'           => $request->approver_id,
            'approver_user_id'      => $request->approver_user_id,
            'approver_source_id'    => $request->approver_source_id,
            'vehicle_type'          => $request->vehicle_type,
            'user_type'             => $request->approver_type,
            'signatory_type'        => $request->signatory_type,
            'position'              => $request->position,
            'hierarchy'             => $request->hierarchy,
            'updated_by'            => session('user')['user_id'],
            'update_user_source_id' => session('user')['source_id'],
        ];

        $this->approver->update_approver($params);
    }
}
