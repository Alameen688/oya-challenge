<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Invite;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Invite as InviteResource;
use App\Http\Resources\UserCollection;
use Validator;


/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="/api",
 *     host="localhost:8000",
 *     schemes={"http", "https"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="OyaChallenge API",
 *         description="API documentation for Oyapay fullstack challenge",
 *         @SWG\Contact(name="Ogundiran Al-Ameen", email="ogundiran12@gmail.com"),
 *     ),
 *      @SWG\Definition(
 * 			definition="Agent",
 * 			required={"name", "phone_number", "business_name"},
 * 			@SWG\Property(property="id", type="string", example="2"),
 * 			@SWG\Property(property="name", type="string", example="Sola Kayode"),
 * 			@SWG\Property(property="phone_number", type="string", example="08134021453"),
 * 			@SWG\Property(property="created_at", type="string", example="2018-06-28 14:26:08"),
 * 		),
 *      @SWG\Definition(
 * 			definition="Admin",
 * 			required={"name", "phone_number", "business_name"},
 * 			@SWG\Property(property="id", type="string", example="2"),
 * 			@SWG\Property(property="name", type="string", example="Simi"),
 * 			@SWG\Property(property="phone_number", type="string", example="08134021453"),
 * 			@SWG\Property(property="business_name", type="string", example="Oyapay"),
 * 			@SWG\Property(property="created_at", type="string", example="2018-06-28 14:26:08"),
 * 		),
 * 
 *       @SWG\Definition(
 * 			definition="NewAdmin",
 * 			required={"name", "phone_number", "password", "password_confirmation", "business_name"},
 * 			@SWG\Property(property="name", type="string", example="Simi"),
 * 			@SWG\Property(property="phone_number", type="string", example="08134021453"),
 * 			@SWG\Property(property="business_name", type="string", example="Oyapay"),
 * 			@SWG\Property(property="password", type="string", example="whatever"),
 * 			@SWG\Property(property="password_confirmation", type="string", example="whatever"),
 * 		),
 * 
 *      @SWG\Definition(
 * 			definition="Invite",
 * 			required={"name", "phone_number", "token", "status"},
 * 			@SWG\Property(property="id", type="string", example="2"),
 * 			@SWG\Property(property="name", type="string", example="Sola Kayode"),
 * 			@SWG\Property(property="phone_number", type="string", example="08134021453"),
 * 			@SWG\Property(property="token", type="string", example="$2y$10$uACQUstEGKVM7vlV6DvrN.NJFJqlE1nDIQ7gJUvJI8pe4Mnj49cAq"),
 * 			@SWG\Property(property="status", type="string", example="pending"),
 * 			@SWG\Property(property="created_at", type="string", example="2018-06-28 14:26:08"),
 * 		),
 * 
 *      @SWG\Definition(
 * 			definition="CompletedInvite",
 * 			required={"name", "phone_number", "token", "status"},
 * 			@SWG\Property(property="id", type="string", example="2"),
 * 			@SWG\Property(property="name", type="string", example="Osoko Biodun"),
 * 			@SWG\Property(property="phone_number", type="string", example="08134021453"),
 * 			@SWG\Property(property="token", type="string", example="$2y$10$uzYilYJX1y/Ey0EkOuwS.e6UoRjlbiW3my/my5J659g5RGUUBLNju"),
 * 			@SWG\Property(property="status", type="string", example="completed"),
 * 			@SWG\Property(property="created_at", type="string", example="2018-06-28 14:26:08"),
 * 		),
 * 
 * 
 * )
 */
class ApiController extends Controller
{
    /**
     * @SWG\Get(
     *      path="/invites",
     *      tags={"Invites"},
     *      operationId="getAllInvites",
     *      summary="Get all invites",
     *      description="Returns information of all invites that has been sent",
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="success",
     *              @SWG\Schema(
     *                  @SWG\Property(
     *                      property="status",
     *                      example="success",
     *                  ),
     *                  @SWG\Property(
     *                      property="data", 
     *                      type="array", 
     *                      @SWG\Items(
     *                          ref="#/definitions/Invite"
     *                      )
     *                  ),
     *                  
     *              ),
     *       ),
     * 
     * )
     *
     */
    public function getAllInvites()
    {
        $invites = Invite::all();
        
        $result['invites'] = $invites;
        InviteResource::withoutWrapping();
        return new InviteResource($result);
    }

    /**
     * @SWG\Get(
     *      path="/invites/pending",
     *      tags={"Invites"},
     *      operationId="getPendingInvites",
     *      summary="Get all pending invites",
     *      description="Returns information of all pending invites",
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="success",
     *              @SWG\Schema(
     *                  @SWG\Property(
     *                      property="status",
     *                      example="success",
     *                  ),
     *                  @SWG\Property(
     *                      property="data", 
     *                      type="array", 
     *                      @SWG\Items(
     *                          ref="#/definitions/Invite"
     *                      )
     *                  ),
     *                  
     *              ),
     *       ),
     * 
     * )
     *
     */
    public function getPendingInvites()
    {
        $invites = Invite::where('status','pending')->latest()->get();
        
        $result['invites'] = $invites;
        InviteResource::withoutWrapping();
        return new InviteResource($result);
    }


    /**
     * @SWG\Get(
     *      path="/invites/completed",
     *      tags={"Invites"},
     *      operationId="getCompletedInvites",
     *      summary="Get all completed invites",
     *      description="Returns information of all completed invites",
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="success",
     *              @SWG\Schema(
     *                  @SWG\Property(
     *                      property="status",
     *                      example="success",
     *                  ),
     *                  @SWG\Property(
     *                      property="data", 
     *                      type="array", 
     *                      @SWG\Items(
     *                          ref="#/definitions/CompletedInvite"
     *                      )
     *                  ),
     *                  
     *              ),
     *       ),
     * 
     * )
     *
     */
    public function getCompletedInvites()
    {
        $invites = Invite::where('status','completed')->latest()->get();
        
        $result['invites'] = $invites;
        InviteResource::withoutWrapping();
        return new InviteResource($result);
    }

    /**
     * @SWG\Get(
     *      path="/users/admin",
     *      tags={"Admin"},
     *      operationId="getAdminUsers",
     *      summary="Get all admin accounts",
     *      description="Returns information of all existing admin accounts",
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *              @SWG\Schema(
     *                  @SWG\Property(
     *                      property="status",
     *                      example="success",
     *                  ),
     *                  @SWG\Property(
     *                      property="data", 
     *                      type="array", 
     *                      @SWG\Items(
     *                          ref="#/definitions/Admin"
     *                      )
     *                  ),
     *                  
     *              ),
     *       ),
     * 
     * )
     *
     */
    public function getAdminUsers()
    {
        $allAdmin = User::where('role', 'admin')->latest()->get(); 
        //dd($allAdmin);
        $result['users'] = $allAdmin;
        UserCollection::withoutWrapping();
        return new UserCollection($result);
    }

    /**
     * @SWG\Get(
     *      path="/find/admin/{phone_number}",
     *      operationId="getAdminByPhone",
     *      tags={"Admin"},
     *      summary="Get admin details by phone number",
     *      description="Gets admin details using phone number and returns the info",
     *      @SWG\Parameter(
     *          name="phone_number",
     *          description="admin's phone number",
     *          required=true,
     *          type="string",
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="success",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="status",
     *                  example="success",
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Admin"
     *              )
     *          )
     *       ),
     * )
     *
     */
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

    /**
     * @SWG\Get(
     *      path="/users/agent",
     *      tags={"Agent"},
     *      operationId="getAgentUsers",
     *      summary="Get all agent accounts",
     *      description="Returns information of all existing agent accounts",
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="success",
     *              @SWG\Schema(
     *                  @SWG\Property(
     *                      property="status",
     *                      example="success",
     *                  ),
     *                  @SWG\Property(
     *                      property="data", 
     *                      type="array", 
     *                      @SWG\Items(
     *                          ref="#/definitions/Agent"
     *                      )
     *                  ),
     *                  
     *              ),
     *       ),
     * 
     * )
     *
     */
    
    public function getAgentUsers()
    {
        $allAgent = User::where('role', 'agent')->latest()->get(); 

        $result['users'] = $allAgent;
        UserCollection::withoutWrapping();

        return new UserCollection($result);
    }

    /**
     * @SWG\Get(
     *      path="/find/agent/{phone_number}",
     *      operationId="getAgentByPhone",
     *      tags={"Agent"},
     *      summary="Get agent details by phone number",
     *      description="Gets agent details using phone number and returns the info",
     *      @SWG\Parameter(
     *          name="phone_number",
     *          description="agent's phone number",
     *          required=true,
     *          type="string",
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="success",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="status",
     *                  example="success",
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Agent",
     *              )
     *          )
     *       ),
     * )
     *
     */

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

    /**
     * Create a new admin account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/admin/create",
     *     description="Registers a new user and returns details.",
     *     operationId="createAdmin",
     *     produces={"application/json"},
     *     tags={"Admin"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         @SWG\Schema(
     *              ref="#/definitions/NewAdmin",
     *         )
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="success",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                  property="status",
     *                  example="success",
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Admin",
     *              )
     *          )
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     */
    
    public function createAdmin()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255|unique:users',
            'business_name' => 'required|string|max:255',
            'password_confirmation' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }
        $admin = User::create([
            'name' => request('name'),
            'phone_number' => request('name'),
            'password' =>  Hash::make(request('password')),
            'business_name' => request('business_name'),
            'role' => 'admin',
        ]);

        if(!$admin){
            $result['status'] = 'error';
            $result['message'] = "Unable to create admin account, try again later"; 
        }else{
            $result['status'] = 'success';
            $result['user'] = $admin; 
        }

        UserResource::withoutWrapping();

        return new UserResource($result);
    }

    
}
