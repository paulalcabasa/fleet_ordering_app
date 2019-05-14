<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect_login()
    {
  
    	   return redirect()->intended('http://'.$this->host.'/webapps/');
    }
}
