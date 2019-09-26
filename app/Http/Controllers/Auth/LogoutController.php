<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    protected $host;

    public function __construct()
    { 
        $this->host = config('app.hostname') . '/' . config('app.webapps_url');    
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->intended($this->host.'/login/logout');
    }
}
