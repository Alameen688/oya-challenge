<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Invite;

class AgentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createAgent()
    {
        return view('create-agent');
    }

    public function storeAgent()
    {
        $this->validate(request(),[
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255|unique:users',
        ]);

        //save to invite db and use agents phone number to generate token
        $invite = Invite::create([
            'name' => request('name'),
            'phone_number' => request('phone_number'),
            'token' => Hash::make(request('phone_number'))
        ]);

        request()->session()->flash('status', 'New agent added successfully, an invite has been sent to the agent\'s phone');
        return redirect()->home();
    }
}
