<?php

namespace App\Http\Controllers\Auth;

use App\OracleUser;
use App\Helpers\UserTypeIdentification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $user_type;

    public function __construct(UserTypeIdentification $type)
    {
        $this->middleware('guest')->except('logout');
        $this->user_type = $type;
    }

    public function authenticate($user_id, OracleUser $oracle_user)
    {
        echo 'AUTHENTICATING...';
      //  die;
        // Redirect if authenticated already
        if (Auth::check()) return redirect()->route('home');

        // Query user data (Source: Oracle or IPC Portal)
        $user = $oracle_user->get($user_id)[0];
        
        // Existence validation
            
        
        // Auth Guards: web or oracle_users
        $auth = Auth::guard($this->user_type->user_guard_type($user->source_id))
        ->loginUsingId($user->user_id);

        if ($auth) {
            $optional_middle = $user->middle_name ?? '';

            // User harnessed data
            $user_session = [
                'user_id'        => $user->user_id,
                'first_name'     => $user->first_name,
                'last_name'      => $user->last_name,
                'username'       => $user->user_name,
                'fullname'       => $user->first_name .' '. $optional_middle .' '. $user->last_name,
                'email'          => $user->email,
                'section'        => $user->section,
                'department'     => $user->department,
                'division'       => $user->division,
                'user_type_name' => $user->user_type_name
            ];

            // Save user instance on session
            session(['user' => $user_session]);

            // Redirect User on initial page
            return redirect()->route('dashboard');
        }
        else {
            return back();
        }
    }
}