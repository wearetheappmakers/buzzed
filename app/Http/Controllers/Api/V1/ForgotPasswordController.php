<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Message;
use Hash;
use Mail;

class ForgotPasswordController extends Controller
{
	

	use SendsPasswordResetEmails;

    
	public function sendResetLinkEmail(Request $request)
    {

        \Config::set('jwt.user', "App\User");
        \Config::set('auth.providers.users.model', \App\User::class);
        // \Config::set('mail.MAIL_FROM_ADDRESS', 'abmart@gmail.com');

        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        // $credentials = ['email' => $this->credentials($request)];
        // $response = $this->broker()->sendResetLink($credentials, function (Message $message) {
        //     $message->subject($this->getEmailSubject());
        // });

        // dd($response);

        // switch ($response) {
        //     case Password::RESET_LINK_SENT:
        //         return response()->json(['status'=>1,'email' => trans($response)]);
        //     case Password::INVALID_USER:
        //         return response()->json(['status'=>0,'email' => trans($response)]);
        // }

        $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
        return response()->json(['status'=>1,'message'=> 'We have mailed to reset link.']);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('users');
    }

    public function autoGeneratePassword(Request $request){
        $check_mail = User::where('email',$request->email)->first();

        if (!empty($check_mail)) {
            $random = str_random(8);
            $password = Hash::make($random);
            $check_mail->password = $password;
            $check_mail->spassword = $random;
            $check_mail->save();

            $data=['email'=>$request->email,'password'=>$random ];
            Mail::send('mail.password_reset', $data, function($message) use($data) {
                $message->to($data['email']);
                $message->subject('Reset Password Form AB Mart');
            });

            return response()->json(['success' => 1,'message' => 'password sent to your email id']);
        }else{
            return response()->json(['success' => 1,'message' => 'User not Authorized! Try with your registered email.']);
        }
    }
}
