<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('usersData', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        return view('users.create');
    }
    public function store(CreateUserRequest  $request)
    {
        $path = $request->file('image')->store('images', 'public');
        User::create([
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
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $users = User::find($id);
        return view('editUser', compact('users'));
    }
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('images', 'public');
            Storage::disk('public')->delete($user->image);
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

        return redirect()->route('users.index');
    }
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        $imagePath = public_path('storage/') . $user->image;

        if(file_exists($imagePath)){
            @unlink($imagePath);
        }
        return redirect()->route('users.index');

    }
}
