<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(CreateUserRequest  $request)
    {
        if($request->hasFile('image')){
            $path = $request->file('image')->store('images', 'public');
        }
        else{
            $path = $request->file('image');
        }
        $user = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hobbies' => json_encode($request->hobbie),
            'gender' => $request->gender,
            'image' => $path,
        ]);
        return redirect()->route('users.index');


    }
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('images', 'public');
            if($user->image){
                Storage::disk('public')->delete($user->image);
            }
        } else{
            $path = $user->image;
        }

        $user->update([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => $request->password == null ? $user->password : hash::make($request->password),
            'hobbies' => json_encode($request->hobbie),
            'gender' => $request->gender,
            'image' => $path,
        ]);
        return response()->json(['success'=>'user update Successfully.']);

    }
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        Storage::disk('public')->delete($user->image);
        return response()->json(['success'=>'user delete Successfully.']);
    }
    public function search(Request $request)
    {
            $searchTerm = $request->input('search');

            if ($searchTerm) {
                $users = User::where('first_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('hobbies', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%')
                    ->get();

                return response()->json([
                    'html' => view('users.search', compact('users'))->render()
                ]);
            }
            else{
                $users = User::all();
                return response()->json([
                    'html' => view('users.search', compact('users'))->render()
                ]);
            }

    }
}
