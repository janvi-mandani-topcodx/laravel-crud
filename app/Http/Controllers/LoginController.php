<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                return redirect()->route('posts.index');
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
        $email = $request->email;
        $user = User::where('email',$email)->first();
        if($user){
            return redirect()->route('reset.password');
        }
        else{
            if ($request->ajax()) {
                return response()->json([
                    'errors' => ['email' => ['Email is not found']],
                ], 422);
            }
        }
    }

    public function viewReset()
    {
        return view('reset-password');
    }

    public function reset(ResetRequest $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $oldPassword = $input['oldPassword'];
        $newPassword = $input['newPassword'];
        $confirmpassword = $input['confirmPassword'];
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

}
