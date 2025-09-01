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
            'full_name' => $comment->firstLetter,
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
