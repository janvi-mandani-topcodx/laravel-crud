<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $role = Auth::user()->roles->pluck('name')->first();
        if($role == 'admin'){
           $messages = Message::where('admin_id', Auth::id())->get();
        }
        else{
            $messages = Message::where('user_id' , Auth::id())->get();
        }

            return view('chat' , compact('messages'));
    }
    public function store(Request $request)
    {
            $input = $request->all();
            $path = isset($input['image']) ? $input['image']->store('images', 'public') : null;
            $role = Auth::user()->roles->pluck('name')->first();
            $sendByAdmin = $role == 'admin' ? true : false;
            $message = MessageReply::create([
                'message_id' => $input['message_id'],
                'message' => isset($input['message']) ? $input['message'] : null,
                'sent_by_admin' => $sendByAdmin,
                'image' => $path,
            ]);
            return response()->json([
                'id' => $message->id,
                'message' => $message->message ?? '',
                'image' => asset('storage/' . $message->image),
                'send_by_admin' => $message->sent_by_admin,
                'created_at' => $message->created_at
            ]);
    }

    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $message = MessageReply::findOrFail($id);
        if($request->hasFile('image')){
            $path = $input['image']->store('images', 'public');
            if($message->image){
                Storage::disk('public')->delete($message->image);
            }
        } else{
            $path = $message->image;
        }
        $messageText  =  isset($input['message']) ? $input['message'] : null;
        $message->update([
            'message' =>$messageText,
            'image' => $path,
        ]);
        return response()->json(
            [
                'success' => true,
                'message' => $message->message,
                'image' => $path,
            ]
        );
    }

    public function destroy(string $id)
    {
        $message = MessageReply::find($id);
        $message->delete();
        if ($message->image != null) {
            Storage::disk('public')->delete($message->image);
        }
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
                        $html .= '<div id="one-user" style="display:flex;"  data-id="' . $user->id . '" data-image="' . $user->imageUrl . '" data-fullname="' . $user->fullName . '">
                                      <div class="col-4 p-0" style="width: 100px">
                                            <img style="height: 48px;  width: 46px;" class="img-fluid rounded-circle" src="' . $user->imageUrl . '" alt="Uploaded Image" >
                                        </div>
                                        <div class="col-8 d-flex justify-content-end align-items-end px-0" style="padding-top: 20px;">
                                            <p>' . $user->fullName . '</p>
                                         </div>
                                    </div>';
                }
            }
            else{
                $html .='<p>No admin found</p>';
            }
            return response()->json(['html' => $html]);
        }

        return view('chat');
    }

    public function message(Request $request)
    {
        $input = $request->all();
        $adminId = $input['id'];
        $authId = Auth::id();
        $role = Auth::user()->roles->pluck('name')->first();
        if($role == 'admin'){
            $message = Message::updateOrCreate(['admin_id' => $adminId],[
                'user_id' => $adminId,
                'admin_id' => $authId
            ]);
        }
        else{
            $message = Message::updateOrCreate(['admin_id' => $adminId],[
                'user_id' => $authId,
                'admin_id' => $adminId
            ]);
        }
        $otherUser = ($message->admin_id == $authId) ? $message->user : $message->admin;

            $html = '<div id="user" style="display:flex;" data-user-id="' . $otherUser->id . '" data-id="' . $message->id . '" data-image="' . $otherUser->imageUrl . '" data-fullname="' . $otherUser->fullName . '">
                    <div class="col-4 p-0" style="width: 100px">
                        <img style="height: 48px;  width: 46px;" class="img-fluid rounded-circle" src="' . $otherUser->imageUrl . '" alt="Uploaded Image">
                    </div>
                    <div class="col-8 d-flex justify-content-end align-items-end px-0" style="padding-top: 20px;">
                        <p>' . $otherUser->fullName . '</p>
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
        $message = Message::with('messageReplies')->find($input['id']);
        $html = '';
            foreach ($message->messageReplies as $messageReply){
                $sendByAdmin = $messageReply->sent_by_admin == 1 ? 'text-end' : 'text-start' ;
                $sendMessage = $sendByAdmin == 'text-end' ? 'justify-content-end' : 'justify-content-start';
                if ($messageReply->sent_by_admin == 1 && auth()->user()->id == $message->admin_id ||
                    $messageReply->sent_by_admin == 0 && auth()->user()->id == $message->user_id)
                {
                    $display = '';
                }
                else {
                    $display = 'd-none';
                }

                $image = $messageReply->image == null ? '': asset('storage/' . $messageReply->image) ;
                $dNone = $image == '' ? 'd-none' : '';
                    $html .= '<div data-id="' . $messageReply->id . '" data-send="' . $messageReply->sent_by_admin . '" class="one-message '.$sendByAdmin.' message-data-'.$messageReply->id .'">
                        <small>'.$messageReply->created_at.'</small><br>
                           <div class="d-flex '.$sendMessage.'">
                                <p class="message-text">'. $messageReply->message . '</p>
                                <img class="message-image img-fluid img-thumbnail  '.$dNone.'" src="'. $image .'" alt="Uploaded Image" width="200" style="height: 126px;">
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
                                            <span  class="edit-btn dropdown-item m-0" data-message = "'.$messageReply->message.'" data-action="'.$messageReply->id.'" data-image="'. $image .'"> Edit </span>
                                        </li>
                                        <li>
                                            <span class="delete-btn dropdown-item" data-id="'.$messageReply->id.'">Delete</span>
                                        </li>
                                    </ul>
                                </span>
                           </div>
                    </div>';
            }
        return response()->json([
            'html' => $html ,
            'message_id' => $message->id,
            ]);
    }
}
