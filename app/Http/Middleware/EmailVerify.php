<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerify
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if($user && $user->email_verified_at){
//            return redirect()->route('email.verify');
        }
        return $next($request);
    }
}
