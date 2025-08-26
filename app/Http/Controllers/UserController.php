<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest  $request)
    {
//        dd($request->all());
//        $validatedData = $request->validate();
//        if($request->hasfile('image')){
            $path = $request->file('image')->store('images', 'public');
//        }
        User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hobbies' => json_encode($request->hobbie),
            'gender' => $request->gender,
            'image' => $path,
        ]);
//        DB::User([
//            'first_name' => $request->firstName,
//            'last_name' => $request->lastName,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//            'hobbies' => json_encode($request->hobbie),
//            'gender' => $request->gender,
//            'image' => $path,
//        ]);
        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::find($id);
        return view('editUser', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
//        $user = User::find($id);
//        dd($request->all());

        if($request->hasFile('image')){
            $path = $request->file('image')->store('images', 'public');
        }
        else{
            $path = User::find($id)->image;
        }

        if($request->password == null){
            $path = User::find($id)->password;
        }
        else{
            $path = $request->password;
        }

        $user = User::find($id);
         $user->update([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hobbies' => json_encode($request->hobbie),
            'gender' => $request->gender,
            'image' => $path,
        ]);
        return redirect()->route('users.index');

//if ($request->hasFile('image')) {
//$imagePath = public_path('storage/') . $user->image;
//if (file_exists($imagePath)) {
//@unlink($imagePath);
//
//}
//    $user->image = $path;
//}
//        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        $imagePath = public_path('storage/') . $user->image;

        if(file_exists($imagePath)){
            @unlink($imagePath);
        }
    }
}
