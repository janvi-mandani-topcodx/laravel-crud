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
    public function index(Request $request)
    {
        if (Auth::check()) {
            $searchTerm = $request->input('search');

            if ($searchTerm) {
                $posts = Post::where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchTerm . '%')
                    ->get();
            } else {
                $posts = Post::all();
            }

            if ($request->ajax()) {
                $html = '';
                foreach ($posts as $post) {
                    $html .= '<tr id="onePost" data-id="' . $post->id . '">
                    <td>' . $post->id . '</td>
                    <td>' . $post->user_id . '</td>
                    <td>' . $post->title . '</td>
                    <td>' . $post->description . '</td>
                    <td>' . $post->status . '</td>
                    <td>
                        <img class="img-fluid img-thumbnail" src="' . $post->postImageUrl . '" width="200" height="100" style="height:126px;">
                    </td>
                    <td class="d-flex justify-content-center align-items-center" style="height:176px;">

                            <button type="button" id="delete-post" class="btn btn-danger btn-sm my-3" data-id="' . $post->id . '">DELETE</button>

                        <a href="' . route('posts.edit', $post->id) . '" class="btn btn-warning d-flex justify-content-center align-items-center col-6">Edit</a>
                    </td>
                </tr>';
                }
                return response()->json(['html' => $html]);
            }

            return view('posts.index', compact('posts'));
        }

        return view('posts.index', ['posts' => collect()]);
    }

    public function create()
    {
        $user = Auth::user();
        $role = $user->roles->first();
        if ($role->permissions->where('name', 'create post')->isNotEmpty()) {
                return view('posts.create');
        }
        else{
            return redirect()->route('posts.index')->with(['error' => "You don't have permission to create post."]);
        }
    }

    public function store(CreatePostRequest $request)
    {
        $input = $request->all();
        $path = isset($input['image']) ? $input['image']->store('images', 'public') : null;

        $user = Auth::user();
        $user->posts()->create([
            'title' => $input['title'],
            'description' => $input['description'],
            'status' => $input['status'],
            'image' => $path,
        ]);
        return response()->json(['success'=>'Post create successfully.']);
    }
    public function edit(string $id)
    {
        $user = Auth::user();
        $role = $user->roles->first();
        if ($role->permissions->where('name', 'update post')->isNotEmpty()) {
                $post = Post::find($id);
                return view('posts.edit', compact('post'));
        }
        else{
            return redirect()->route('posts.index')->with(['error' => "You don't have permission to update post."]);
        }

    }

    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::find($id);

        $input = $request->all();

        if($request->hasFile('image')){
            $path = $input['image']->store('images', 'public');
            if($post->image){
                Storage::disk('public')->delete($post->image);
            }
        }
        else{
            $path = $post->image;
        }

        $post->update([
            'title' => $input['title'],
            'description' => $input['description'],
            'status' => $input['status'],
            'image' => $path,
        ]);

        return response()->json(['success'=>'Post update successfully.']);
    }
    public function destroy(string $id)
    {
        $authUser = Auth::user();
        foreach ($authUser->roles as $role) {
            if ($role->permissions->contains('name', 'delete post')) {
                $post = Post::find($id);
                $post->delete();
                if ($post->image != null) {
                    Storage::disk('public')->delete($post->image);
                }
                return response()->json(['success' => 'Post delete successfully.']);

            } else {
                return redirect()->route('posts.index')->with(['error' => "You don't have permission to delete post."]);
            }
        }
    }
}
