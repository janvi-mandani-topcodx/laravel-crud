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
                    <td><img class="img-fluid img-thumbnail" src="' . $post->postImageUrl . '" width="200" height="100" style="height:126px;"></td>
                    <td class="d-flex justify-content-center align-items-center" style="height:176px;">
                        <form action="' . route('posts.destroy', $post->id) . '" method="POST" class="col-6">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" id="deletePost" class="btn btn-danger btn-sm my-3" data-id="' . $post->id . '">DELETE</button>
                        </form>
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
        return view('posts.create');
    }

    public function store(CreatePostRequest $request)
    {
        $input = $request->all();
        $path = $input['image']->store('images', 'public');
        Post::create([
            'user_id' => Auth::user()->id,
            'title' => $input['title'],
            'description' => $input['description'],
            'status' => $input['status'],
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
            $path = $input['image']->store('images', 'public');
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
}
