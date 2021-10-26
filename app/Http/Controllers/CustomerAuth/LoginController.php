<?php

namespace App\Http\Controllers\CustomerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use App\User;

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

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/customer/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customer.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    public function login(Request $request){
         $request->validate([
            'number' => 'required',
        ]);

        $password = User::Where('number',$request->number)->value('spassword');
   
        if (Auth::guard('customer')->attempt(['number' => $request->number, 'password' => $password ])) {
            return redirect()->intended('customer/home')
                        ->withSuccess('You have Successfully loggedin');
        }

         $credentials = $request->only('number',);
        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended('customer/home')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function customerValidate(Request $request){
        $user = User::Where('number',$request->number)->first();

        if (!empty($user)) {
            return response()->json(['success' => 1]);
        }else{
            return response()->json(['success' => 0]);
        }
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }
}
