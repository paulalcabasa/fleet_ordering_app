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
      //  $this->host = $_SERVER['HTTP_HOST'];    
        $this->host = 'localhost';    
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->intended('http://'.$this->host.'/webapps/login/logout');
    }
}
