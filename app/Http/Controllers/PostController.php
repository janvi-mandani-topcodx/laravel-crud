<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index()
    {
        if(Auth::check()){
            $posts = Post::get();
        }
        else{
            $posts = collect();
        }
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(CreatePostRequest $request)
    {
        $path = $request->file('image')->store('images', 'public');
         Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $path,
        ]);
        return response()->json(['success'=>'Post create successfully.']);
    }
    public function edit(string $id)
    {
        $post = Post::find($id);
        $comments = $post->comments;

        return view('posts.edit', compact('post' , 'comments'));
    }

    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::find($id);

        $input = $request->all();

        if($request->hasFile('image')){
            $path = $request->file('image')->store('images', 'public');
            Storage::disk('public')->delete($post->image);
        } else{
            $path = $post->image;
        }

        $post->update([
            'title' => $input['title'],
            'description' => $input['description'],
            'status' => $input['status'],
            'image' => $path,
        ]);

        return response()->json(['success'=>'Post create successfully.']);
    }
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        Storage::disk('public')->delete($post->image);
        return response()->json(['success'=>'user delete Successfully.']);
    }

    public  function searchPost(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $posts = Post::where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('status', 'LIKE', '%' . $searchTerm . '%')
                ->get();

            return response()->json([
                'html' => view('posts.search', compact('posts'))->render()
            ]);
        }
        else {
            $posts = Post::where('user_id', Auth::user()->id)->get();
            return response()->json([
                'html' => view('posts.search', compact('posts'))->render()
            ]);
        }
    }
}
