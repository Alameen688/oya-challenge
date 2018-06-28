<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invite;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Invite as InviteResource;
use App\Http\Resources\UserCollection;


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
        
        $result['invites'] = $invites;
        InviteResource::withoutWrapping();
        return new InviteResource($result);
    }

    public function getPendingInvites()
    {
        $invites = Invite::where('status','pending')->latest()->get();
        
        $result['invites'] = $invites;
        InviteResource::withoutWrapping();
        return new InviteResource($result);
    }

    public function getCompletedInvites()
    {
        $invites = Invite::where('status','completed')->latest()->get();
        
        $result['invites'] = $invites;
        InviteResource::withoutWrapping();
        return new InviteResource($result);
    }

    public function getAdminUsers()
    {
        $allAdmin = User::where('role', 'admin')->latest()->get(); 
        //dd($allAdmin);
        $result['users'] = $allAdmin;
        UserCollection::withoutWrapping();
        return new UserCollection($result);
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
        $allAgent = User::where('role', 'agent')->latest()->get(); 

        $result['users'] = $allAgent;
        UserCollection::withoutWrapping();

        return new UserCollection($result);
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

    


}
