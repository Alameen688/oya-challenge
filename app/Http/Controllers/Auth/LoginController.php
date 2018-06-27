<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*
     * Overide the username function in AuthenticatesUsers trait 
     * to make the field to check for in db phone_number and not the default email
     * So phone_number and password for login
     */
    public function username()
    {
        return 'phone_number';
    }

    /*
     * Overide the credentials function in AuthenticatesUsers trait 
     * to make the it also check is user account is an admin account
     * i.e role = admin
     * So phone_number and password and role for login
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials = array_add($credentials, 'role', 'admin');
        return $credentials;
    }
}
