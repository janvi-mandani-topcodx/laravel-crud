<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetRequest;
use App\Jobs\SendEmailVerify;
use App\Mail\EmailVarification;
use App\Mail\ResetPassword;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('login');
    }
    public  function login(LoginRequest $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $password = $input['password'];
        $user = User::where('email',$email)->first();
        if($user){
            if(Hash::check($password , $user->password)){
                Auth::login($user);
                if($user->email_verified_at == null) {
                    return response()->json(['verify'=>'email.verify']);
                }
                else{
                    return response()->json(['posts'=>'posts.index']);
                }
            }
            else{
                if ($request->ajax()) {
                    return response()->json([
                        'errors' => ['password' => ['Password is incorrect']],
                    ], 422);
                }
            }
        }
        else{
            if ($request->ajax()) {
                return response()->json([
                    'errors' => ['email' => ['Email is not found']],
                ], 422);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.view');
    }

    public function viewForgot()
    {
        return view('forgot-password');
    }

    public function forgot(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $user = User::where('email',$email)->first();
        if($user){
                $to = $user;
                $message = "hello Welcome";
                $subject = "Mail send";
                $url = route('reset.password') ."?email=".$input['email'];
                Mail::to($to)->send(new ResetPassword($message , $subject , $url));
        }
        else{
            if ($request->ajax()) {
                return response()->json([
                    'errors' => ['email' => ['Email is not found']],
                ], 422);
            }
        }
    }
    public function viewReset(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        return view('reset-password'  , compact('email'));
    }

    public function reset(ResetRequest $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $oldPassword = $input['oldPassword'];
        $newPassword = $input['newPassword'];
        $user = User::where('email',$email)->first();
        if($user){
            if(Hash::check($oldPassword , $user->password)){
                $user->update([
                    'password' => Hash::make($newPassword)
                ]);
                return redirect()->route('posts.index');
            }
            else{
                if ($request->ajax()) {
                    return response()->json([
                        'errors' => ['oldPassword' => ['Password is incorrect']],
                    ], 422);
                }
            }
        }
        else{
            if ($request->ajax()) {
                return response()->json([
                    'errors' => ['email' => ['Email is not found']],
                ], 422);
            }
        }
    }

    public function viewVerify()
    {

        if(auth()->user()->email_verified_at != null){
            return redirect()->route('posts.index');
        }
        return view('email-verify');
    }

    public function verify()
    {
        $email = Auth::user()->email;
        $user = User::where('email',$email)->first();


        $message = "hello Welcome";
        $subject = "Mail send";
        SendEmailVerify::dispatch($message, $subject);
        $user->email_verified_at = now();
        $user->save();

    }
}
