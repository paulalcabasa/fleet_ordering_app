<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect_login()
    {
        //'http://localhost/fleet_ordering_app/dashboard'
  		return redirect()->intended(config('app.hostname') . '/fleet_ordering_app/dashboard');
    }
}
