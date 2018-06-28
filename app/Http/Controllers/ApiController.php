<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invite;
use App\User;
use App\Http\Resources\User as UserResource;


/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="/api/v1",
 *     host="localhost:8000",
 *     schemes={"http", "https"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="OyaChallenge API",
 *         description="API documentation for Oyapay fullstack challenge",
 *         @SWG\Contact(name="Ogundiran Al-Ameen", email="ogundiran12@gmail.com"),
 *     ),
 *     @SWG\Definition(
 *         definition="Admin",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */
class ApiController extends Controller
{
    public function getAllInvites()
    {
        $invites = Invite::all();
        
        return response()->json($invites);
    }

    public function getPendingInvites()
    {
        $invites = Invite::where('status','pending')->get();
        
        return response()->json($invites);
    }

    public function getCompletedInvites()
    {
        $invites = Invite::where('status','completed')->get();
        
        return response()->json($invites);
    }

    public function getAdminUsers()
    {
        $allAdmin = User::where('role', 'admin')->get(); 

        return response()->json($allAdmin);
    }

    public function getAdminByPhone($phone)
    {
        $admin = User::where('role', 'admin')
                        ->where('phone_number', $phone)
                        ->first(); 

        if($admin == null){
            $result['status'] = 'error';
            $result['message'] = "Oops! admin account doesn't exist"; 
        }else{
            $result['status'] = 'success';
            $result['user'] = $admin; 
        }

        UserResource::withoutWrapping();

        return new UserResource($result);
    }

    public function getAgentUsers()
    {
        $allAgent = User::where('role', 'agent')->get(); 

        return response()->json($allAgent);
    }

    public function getAgentByPhone($phone)
    {
        $agent = User::where('role', 'agent')
                        ->where('phone_number', $phone)
                        ->first(); 
        
        if($agent == null){
            $result['status'] = 'error';
            $result['message'] = "Oops! agent account doesn't exist"; 
        }else{
            $result['status'] = 'success';
            $result['user'] = $agent; 
        }

        UserResource::withoutWrapping();

        return new UserResource($result);
    }

    public function createAdmin()
    {
        $admin = User::create([
            'name' => request('name'),
            'phone_number' => $phone,
            'password' =>  Hash::make(request('password')),
            'role' => 'admin',
        ]);

        return response()->json($admin);
    }

    public function updateInviteStatus()
    {
        $phone = request('phone_number');
        //Hash::check($agentInvite->phone_number, $token)
        $invite = Invite::where('phone_number', $phone)
          ->update(['status' => 'completed']);

          return response()->json($invite);
    }
    
    public function createAgent()
    {
        $agent = User::create([
            'name' => request('name'),
            'phone_number' => $phone,
            'password' =>  Hash::make(request('password')),
            'role' => 'agent',
        ]);

        return response()->json($agent);
    }


}
