<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::where('user_id' ,Auth::user()->id)->get();
        return view('posts.post-data', compact('posts'));
    }

    public function create()
    {

    }

    public function store(CreatePostRequest $request)
    {
        $path = $request->file('imagePost')->store('images', 'public');
         Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $path,
        ]);
        return redirect('/posts');
    }

    public function show(string $id)
    {

    }
    public function edit(string $id)
    {
        $posts = Post::find($id);
        return view('posts.edit-post', compact('posts'));
    }

    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::find($id);

        if($request->hasFile('imagePost')){
            $path = $request->file('imagePost')->store('images', 'public');
            Storage::disk('public')->delete($post->image);
        } else{
            $path = $post->image;
        }
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $path,
        ]);
        return redirect('/posts');
//        return response()->json(['success'=>'user update Successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        $imagePath = public_path('storage/') . $post->image;

        if(file_exists($imagePath)){
            Storage::disk('public')->delete($post->image);
        }
        return response()->json(['success'=>'user delete Successfully.']);
    }

    public  function searchPost(Request $request)
    {
        $searchTerm = $request->input('searchpost');

        if ($searchTerm) {
            $posts = Post::where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('status', 'LIKE', '%' . $searchTerm . '%')
                ->get();

            return response()->json([
                'html' => view('posts.search-post', compact('posts'))->render()
            ]);
        }

        return response()->json(['html' => '']);
    }
}
