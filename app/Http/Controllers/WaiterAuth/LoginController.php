<?php

namespace App\Http\Controllers\WaiterAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use App\Models\Captain;

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
    public $redirectTo = '/waiter/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('waiter.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('waiter.auth.login');
    }

    public function login(Request $request){

        Auth::guard('admin')->logout();
        Auth::guard('manager')->logout();
        Auth::guard('customer')->logout();

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

       if (Auth::guard('waiter')->attempt(['email' => $request->email, 'password' => $request->password ])) {
        return redirect()->intended('waiter/home')
                    ->withSuccess('You have Successfully loggedin');
        }

        return redirect("waiter/login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('waiter');
    }

    public function logoutToPath() {
        return '/waiter/login';
    }
}
