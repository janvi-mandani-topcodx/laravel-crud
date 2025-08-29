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
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request->post_id,
            'comment' => $request->comment,
        ]);
        return response()->json([
            'id' => $comment->id,
            'comment' => $comment->comment,
            'created_at' => $comment->created_at->toDateTimeString(),
            'post_id' => $comment->post_id,
            'full_name' => $comment->user->first_name . ' ' . $comment->user->last_name,
            'shortname' => strtoupper(substr($comment->user->first_name, 0, 1) . substr($comment->user->last_name, 0, 1)),
        ]);
    }


    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->comment = $request->comment;
        $comment->save();
        return response()->json(['success' => true, 'comment' => $comment->comment]);
    }

    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['success' => true]);
    }
}
