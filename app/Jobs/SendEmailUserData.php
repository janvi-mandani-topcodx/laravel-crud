<?php

namespace App\Jobs;

use App\Mail\EmailUserData;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailUserData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
  public  $subject;
  public $message;
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::all();
        $subject = "users data";
        $message = [];
        $to = auth()->user();
        foreach ($users as $user) {
            $message[] = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'hobbies' => json_encode($user->hobbies),
                'gender' => $user->gender,
            ];
        }
        Mail::to($to)->send(new EmailUserData($message , $subject));
    }
}
