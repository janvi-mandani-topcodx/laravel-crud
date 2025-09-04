<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $role = $user->roles->first();
        if ($role->permissions->where('name', 'create comment')->isNotEmpty()) {
            $input = $request->all();
            $user = Auth::user();
            $comment = $user->comments()->create([
                'post_id' => $input['post_id'],
                'comment' => $input['comment'],
            ]);
            return response()->json([
                'id' => $comment->id,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->toDateTimeString(),
                'post_id' => $comment->post_id,
                'full_name' => $comment->fullName,
                'shortname' => strtoupper(substr($comment->user->first_name, 0, 1) . substr($comment->user->last_name, 0, 1)),
            ]);
        }
        else{
            return redirect()->route('posts.edit')->with(['error' => "You don't have permission to create comment."]);
        }
    }



    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $role = $user->roles->first();
        if ($role->permissions->where('name', 'update comment')->isNotEmpty()) {
            $comment = Comment::findOrFail($id);
            $comment->comment = $request->comment;
            $comment->save();
            if($role->permissions->where('name', 'create comment')->isNotEmpty()){
                $addComment = 'true';
            }
            else{
                $addComment = 'false';
            }
            return response()->json(['success' => true, 'comment' => $comment->comment , 'addComment' => $addComment]);
        }
        else{
            return  redirect()->route('posts.edit')->with(['error' => "You don't have permission to update comment."]);
        }
    }

    public function destroy(string $id)
    {
        $user = Auth::user();
        $role = $user->roles->first();
        if ($role->permissions->where('name', 'update comment')->isNotEmpty()) {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            return response()->json(['success' => true]);
        }
        else{
            return redirect()->route('posts.edit')->with(['error' => "You don't have permission to delete comment."]);
        }
    }
}
