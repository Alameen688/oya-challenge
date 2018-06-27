<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Invite;
use App\User;


class AgentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->only(['inviteAgent', 'storeAgentInvite']);

        /*only guest i.e logged out users should be able to access the create agent form
        /since you can be logged in when creating a new account (agent account) 
        /and also it's is not the logged in admin that will create the account
        /hence you can't be logged in.
        */
        $this->middleware('guest')->only(['showForm', 'createAgent']);
    }

    public function inviteAgent()
    {
        return view('invite-agent');
    }

    public function storeAgentInvite()
    {
        $this->validate(request(),[
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255|unique:invites',
        ]);

        //save to invite db and use agents phone number to generate token
        $invite = Invite::create([
            'name' => request('name'),
            'phone_number' => request('phone_number'),
            'token' => Hash::make(request('phone_number')),
            'status' => 'pending',
        ]);

        request()->session()->flash('status', 'New agent added successfully, an invite has been sent to the agent\'s phone');
        return redirect()->home();
    }

    /**
     * For the purpose of testing 
     * Logged in Admin user will be logged out when trying to access this form via the link
     * This is because ideally when the link is sent to the invited agent via sms they would currently be logged out
     * 
     */
    public function showForm()
    {
        //no needed to do urldecode on the encoded token, query does it automatically
        $name = urldecode(request()->name);
        $token = request()->query('token'); 
        $agentInvite = Invite::where('name', $name)->first();
        if(is_null($agentInvite)){

            request()->session()->flash('status', 'Error! agent invite not found');
            return redirect('/info/error');

        }elseif (!Hash::check($agentInvite->phone_number, $token)) {

            request()->session()->flash('status', 'Sorry! Token is invalid');
            return redirect('/info/error');

        }
        $status = $agentInvite->status;
        return view('create-agent', compact('status','agentInvite'));
    }

    public function createAgent()
    {
        $this->validate(request(),[
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $phone = request('phone_number');
        
        //create user agent account
        $user = User::create([
            'name' => request('name'),
            'phone_number' => $phone,
            'password' =>  Hash::make(request('password')),
            'role' => 'agent',
        ]);

        if(!$user){
            request()->session()->flash('status', 'Error! Unable to create agent account');
            return redirect('/info/error');
        }
        //update invite status to completed
        $agentInvite = Invite::where('phone_number',$phone)->first();
        $data = [
            'status' => 'completed'
        ];

        $agentInvite->update($data);


        request()->session()->flash('status', 'Congratulations! Your agent account has been created successfully.');
        return redirect('/info/success');
    }
}
