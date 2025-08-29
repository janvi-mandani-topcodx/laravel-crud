<?php

namespace App\Http\Controllers;

use App\Mail\EmailVarification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    function mail()
    {
        $to = 'aaa@gmail.com';
        $message = "hello Welcome";
        $subject = "Mail send";
        Mail::to($to)->send(new EmailVarification($message , $subject));
    }
}
