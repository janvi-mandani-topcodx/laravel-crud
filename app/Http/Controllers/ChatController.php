<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $users = [];
        $role = Auth::user()->roles->pluck('name')->first();
        if($role == 'user'){
            $messages = Message::where('user_id' , Auth::id())->get();

        }
        else{
            $messages = Message::where('admin_id' , Auth::id())->get();
        }
        return view('chat' , compact('users' , 'messages'));
    }
    public function store(Request $request)
    {
            $input = $request->all();
            $role = Auth::user()->roles->pluck('name')->first();
            $sendByAdmin = $role == 'admin' ? true : false;
            $message = MessageReply::create([
                'message_id' => $input['message_id'],
                'message' => $input['message'],
                'sent_by_admin' => $sendByAdmin
            ]);
            return response()->json([
                'id' => $message->id,
                'message' => $message->message,
                'send_by_admin' => $message->sent_by_admin,
                'created_at' => $message->created_at
            ]);
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
            $findRole = auth()->user()->roles->pluck('name')->first();
            if($findRole == 'admin'){
                $users = User::whereHas('roles', function ($query) {
                    $query->where('name', 'user');
                })->where(function ($query) use ($searchTerm) {
                    $query->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
                })->get();
            }
            else{
                $users = User::whereHas('roles', function ($query) {
                    $query->where('name', 'admin');
                })->where(function ($query) use ($searchTerm) {
                    $query->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
                })->get();
            }
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
        $adminId = $request->id;
        $message = Message::updateOrCreate(['admin_id' => $adminId],[
            'user_id' => Auth::user()->id,
            'admin_id' => $adminId
        ]);
        $html = '<div id="user" style="display:flex;" data-user-id="'.$message->user->id.'" data-id="'. $message->id .'" data-image="'.$message->user->imageUrl.'" data-fullname="'.$message->user->fullName.'">
        <div class="col-4 p-0" style="width: 100px">
            <img style="height: 48px;  width: 46px;" class="img-fluid rounded-circle" src="'.$message->user->imageUrl.'" alt="Uploaded Image" >
        </div>
        <div class="col-8 d-flex justify-content-end align-items-end px-0" style="padding-top: 20px;">
            <p>'.$message->user->fullName.'</p>
        </div>
    </div>';

        return response()->json([
            'html' => $html,
            'message_id' => $message->id
        ]);
    }
    public function getMessages(Request $request)
    {
        $input = $request->all();
        $message = Message::find($input['id']);
        dd($message);
        $message = Message::with('messageReplies')->find($input['id']);
        $html = '';
            foreach ($message->messageReplies as $messageReply){
                $sendByAdmin = $messageReply->sent_by_admin == 1 ? 'text-end' : 'text-start' ;
                $sendMessage = $sendByAdmin == 'text-end' ? 'justify-content-end' : 'justify-content-start';
                $display  = auth()->user()->id == $message->user_id ? '' : 'd-none';
                    $html .= '<div data-id="' . $messageReply->id . '" data-send="' . $messageReply->sent_by_admin . '" class="one-message '.$sendByAdmin.' message-data-'.$messageReply->id .'">
                        <small>'.$messageReply->created_at.'</small><br>
                           <div class="d-flex '.$sendMessage.'">
                                <p class="message-text">'. $messageReply->message . '</p>
                                <span class="dropdown '.$display.'">
                                    <button type="button" class="border-0 dropdown-toggle"  data-bs-toggle="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="mb-2">
                                            <input type="hidden" name="edit_message" value="'. $messageReply->id .'">
                                            <input type="hidden" name="messageId" value="'.$message->id.'">
                                            <span  class="edit_btn dropdown-item" data-message = "'.$messageReply->message.'" data-action="'.$messageReply->id.'" > Edit </span>
                                        </li>
                                        <li>
                                            <span class="delete_btn dropdown-item" data-id="'.$messageReply->id.'">Delete</span>
                                        </li>
                                    </ul>
                                </span>
                           </div>
                    </div>';
            }
        return response()->json(['html' => $html]);
    }
}
