<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = [];
        $messages = Message::where('user_id' , Auth::user()->id)->with('user')->get();
        return view('chat' , compact('users' , 'messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $input = $request->all();
            $message = MessageReply::create([
                'message_id' => $input['message_id'],
                'message' => $input['message'],
                'sent_by_admin' => true
            ]);
            return response()->json([
                'id' => $message->id,
                'message' => $message->message,
                'send_by_admin' => $message->send_by_admin,
                'created_at' => $message->created_at
            ]);
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $message = MessageReply::findOrFail($id);
        $message->update([
            'message' => $request->message,
        ]);
        return response()->json(['success' => true, 'message' => $message->message]);
    }

    public function destroy(string $id)
    {
        $message = MessageReply::find($id);
        $message->delete();
        return response()->json(['success' => true]);

    }


    public  function chat(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
            })->get();
        }
        else{
            $users = [];
        }
        if ($request->ajax()) {
            $html = '';
            if(count($users) > 0){
                foreach ($users as $user) {
                    $html .= '<div id="oneUser" style="display:flex;" data-id="'. $user->id .'" data-image="'.$user->imageUrl.'" data-fullname="'.$user->fullName.'">
                                      <div class="col-4 p-0" style="width: 100px">
                                            <img style="height: 48px;  width: 46px;" class="img-fluid rounded-circle" src="' . $user->imageUrl .'" alt="Uploaded Image" >
                                        </div>
                                        <div class="col-8 d-flex justify-content-end align-items-end px-0" style="padding-top: 20px;">
                                            <p>'. $user->fullName.'</p>
                                         </div>
                                    </div>';
                }
            }
            else{
//                $html .='<p>No admin found</p>';
            }
            return response()->json(['html' => $html]);
        }

        return view('chat');
    }

    public function message(Request $request)
    {
        $searchAdminId = $request->id;
        Message::create([
            'user_id' => Auth::user()->id,
            'admin_id' => $searchAdminId
        ]);
    }
    public function getMessages(Request $request)
    {
        $messageId = $request->id;

        $message = Message::with('messageReplies')->find($messageId);
        $html = '';
        foreach ($message->messageReplies as $reply) {
            if($reply->sent_by_admin == 1)
            {
                $html .= '<div data-id="' . $reply->id . '" data-send="' . $reply->sent_by_admin . '" class="oneMessage text-right messageData-'.$reply->id .'">
                    <small>'.$reply->created_at.'</small><br>
                        <p class="messageText">'. $reply->message . '</p>
                        <span class="dropdown">
                            <button type="button" class="border-0 dropdown-toggle"  data-bs-toggle="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="mb-2">
                                    <input type="hidden" name="edit_message" value="'. $reply->id .'">
                                    <input type="hidden" name="messageId" value="'.$message->id.'">
                                    <span  class="edit_btn dropdown-item" data-message = "'.$reply->message.'" data-action="'.$reply->id.'" > Edit </span>
                                </li>
                                <li>
                                    <span class="delete_btn dropdown-item" data-id="'.$reply->id.'">Delete</span>
                                </li>
                            </ul>
                        </span>
                </div>';
            }
            else{
                $html .= '<div data-id="' . $reply->id . '" data-send="' . $reply->sent_by_admin . '" >'. $reply->message . '</div>';
            }
        }
        return response()->json(['html' => $html]);
    }

}
