<?php

namespace App\Http\Controllers\ManagerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use App\Staff;

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
    public $redirectTo = '/manager/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('manager.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('manager.auth.login');
    }

    public function login(Request $request){
         $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $role = Staff::Where('email',$request->email)->value('role');

        if ($role == 1) {
           if (Auth::guard('manager')->attempt(['email' => $request->email, 'password' => $request->password ])) {
            return redirect()->intended('manager/home')
                        ->withSuccess('You have Successfully loggedin');
            } 
        }

        return redirect("manager/login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('manager');
    }

    public function logoutToPath() {
        return '/manager/login';
    }
}
