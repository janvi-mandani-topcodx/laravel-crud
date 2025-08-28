<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function viewlogin()
    {
        return view('loginUser');
    }
    public  function login(Request $request)
    {
//        $validation = $request->validate([
//            'email' => 'required|email',
//            'password' =>'required'
//        ]);
//        if(Auth::attempt($validation)){
//            return redirect('/users');
//        }
//        else{
//            return "user is not found";
//        }
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email',$email)->first();
        if($user){
            if(Hash::check($password , $user->password)){
                Auth::login($user);
                return redirect('/users');
            }
            else{
                return "Password is incorrect";
            }
        }
        else{
            return "user is not found";
        }
    }
}
