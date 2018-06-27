<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('showStatus');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invites = Invite::latest()->get();
        return view('home', compact('invites'));
    }

    public function showStatus()
    {
        $statusType = request('status');
        if(strToLower($statusType) == 'success'){
            $alertClass = 'alert-success';
        }elseif(strToLower($statusType) == 'error'){
            $alertClass = 'alert-danger';
        }elseif(strToLower($statusType) == 'warning'){
            $alertClass = 'alert-warning';
        }else{
            $alertClass = 'alert-info';
        }
        return view('info-page',compact('statusType', 'alertClass'));
    }
}
