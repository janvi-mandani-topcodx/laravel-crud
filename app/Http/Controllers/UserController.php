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
    public function index()
    {
        $users = User::get();
        return view('usersData', compact('users'));
    }
    public function create()
    {
    }
    public function store(CreateUserRequest  $request)
    {
        $path = $request->file('image')->store('images', 'public');
        $user = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hobbies' => json_encode($request->hobbie),
            'gender' => $request->gender,
            'image' => $path,
        ]);
//        return response()->json([
//            'id' => $user->id,
//            'first_name' => $user->first_name,
//            'last_name' => $user->last_name,
//            'email' => $user->email,
//            'gender' => $user->gender,
//            'hobbies' => json_decode($user->hobbies),
//            'image_url' => asset('storage/' . $user->image),
//        ]);

        return response()->json(['success'=>'user Create Successfully.']);

    }
    public function show(string $id)
    {
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
        return response()->json(['success'=>'user update Successfully.']);

    }
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        $imagePath = public_path('storage/') . $user->image;

        if(file_exists($imagePath)){
            Storage::disk('public')->delete($user->image);
        }
        return response()->json(['success'=>'user delete Successfully.']);
    }
    public function viewlogin()
    {
        return view('loginUser');
    }
    public  function login(Request $request)
    {
            $email = $request->email;
            $password = $request->password;
            $user = User::where('email',$email)->first();
            if($user){
                if(Hash::check($password , $user->password)){
                    session(['email' => $email , 'id' => $user->id]);
                    return redirect('/users');
                }
                else{
                    return "Password is incorrect";
                }
            }
            else{
                return "user is not found";
            }
    }
}
