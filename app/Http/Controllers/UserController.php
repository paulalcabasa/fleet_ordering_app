<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OracleUser;

class UserController extends Controller
{

    public function user_list(OracleUser $m_users){
        
        $user_type = session('user')['user_type_id'];
        $customer_id = session('user')['customer_id'];

        $users = $m_users->get_users();

        $page_data = array(
            'base_url'      => url('/'),
            'status_colors' => config('app.status_colors'),
            'users'         => $users
        );

        return view('users.users_list',$page_data);
    }

    public function ajax_get_approver(Request $request, OracleUser $m_users){
        $user_id         = $request->user_id;
        $user_source_id  = $request->user_source_id;
        $customer_id     = $request->customer_id;
        $approvers       = $m_users->get_approver($user_id, $user_source_id);
        $dealer_managers = $m_users->get_dlr_managers($customer_id);
        return [
            'approvers'       => $approvers,
            'dealer_managers' => $dealer_managers
        ];
    }
}
