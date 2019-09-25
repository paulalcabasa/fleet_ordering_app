<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OracleUser;
use App\Models\Approver;
use Carbon\Carbon;
class UserController extends Controller
{

    public function user_list(OracleUser $m_users){
        
        $user_type = session('user')['user_type_id'];
        $customer_id = session('user')['customer_id'];

        $users = $m_users->get_users();

        $user_list = [];
        foreach($users as $row){
            $last_login = $row->last_login != "" ? Carbon::parse($row->last_login)->diffForHumans() : "";
            $arr = [
                'last_login' => $last_login,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'dealer_account' => $row->dealer_account,
                'user_type_name' => $row->user_type_name,
                'status_name' => $row->status_name,
                'customer_id' => $row->customer_id,
                'user_id' => $row->user_id,
                'user_source_id' => $row->user_source_id
            ];
            array_push($user_list,$arr);
        }
     
        $page_data = array(
            'base_url'      => url('/'),
            'status_colors' => config('app.status_colors'),
            'users'         => $user_list
        );

        return view('users.users_list',$page_data);
    }

    public function ajax_get_approver(Request $request, OracleUser $m_users){
        $user_id         = $request->user_id;
        $user_source_id  = $request->user_source_id;
        $customer_id     = $request->customer_id;
        $approvers       = $m_users->get_approver($user_id, $user_source_id);
        $dealer_managers = $m_users->get_dlr_managers($customer_id);
        $approver_data = [];
        foreach ($approvers as $row) {
            $arr = [
                'status'              => $row->status == 'true' ? true : false,
                'approver_id'         => $row->approver_id,
                'name'                => $row->name,
                'user_type'           => $row->user_type,
                'requestor_source_id' => $row->requestor_source_id,
                'requestor_user_id'   => $row->requestor_user_id,
                'hierarchy'           => $row->hierarchy,
                'approver_user_id'    => $row->approver_user_id,
                'approver_source_id'  => $row->approver_source_id,
                'status_id'           => $row->status_id
            ];
            array_push($approver_data,$arr);
        }
        return [
            'approvers'       => $approver_data,
            'dealer_managers' => $dealer_managers
        ];
    }

    public function delete_approver(Request $request){
        return $request->approver_id;
    }

    public function save_user_approver(Request $request, Approver $m_approver){
        $approvers = $request->approvers;
        foreach($approvers as $row){
            // Customer Details
            $attrs = 
            // this will used for insert
            [
                'approver_id' => $row['approver_id']
            ];
            $values = 
            // this will be used for other parameters to insert
            [
                'requestor_user_id'     => $row['requestor_user_id'],
                'requestor_source_id'   => $row['requestor_source_id'],
                'approver_user_id'      => $row['approver_user_id'],
                'approver_source_id'    => $row['approver_source_id'],
                'status_id'             => $row['status_id'], // active
                'hierarchy'             => $row['hierarchy'],
                'created_by'            => session('user')['user_id'],
                'create_user_source_id' => session('user')['source_id'],
                'creation_date'         => Carbon::now(),
                'module_code'           => 'PRJ',
                'user_type'             => 'DLR_MANAGER'
            ];
       
            $m_approver->insert_approver($attrs,$values);
           
        }
  
    }
}
