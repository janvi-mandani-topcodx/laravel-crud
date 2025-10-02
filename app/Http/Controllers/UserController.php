<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Jobs\SendEmailUserData;
use App\Mail\EmailVarification;
use App\Mail\ResetPassword;
use App\Models\Message;
//use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
//        $searchTerm = $request->input('search');
//        if ($searchTerm) {
//            $users = User::where('first_name', 'LIKE', '%' . $searchTerm . '%')
//                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
//                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
//                ->orWhere('hobbies', 'LIKE', '%' . $searchTerm . '%')
//                ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%')
//                ->get();
//        }
//        else{
        $users = User::all();
//        }
//        if ($request->ajax()) {
//            $html = '';
//            foreach ($users as $user) {
//                $html .= '<tr id="one-user" data-id="'. $user->id .'">
//                                    <td>'. $user->id .'</td>
//                                    <td>'. $user->first_name.'</td>
//                                    <td>'. $user->last_name .'</td>
//                                    <td>'. $user->email .'</td>
//                                    <td>'. implode(',', json_decode($user->hobbies)).'</td>
//                                    <td>'. $user->gender.'</td>
//                                    <td>
//                                        <img class="img-fluid img-thumbnail" src="'. $user->imageUrl .'" alt="Uploaded Image" width="200" style="height: 126px;">
//                                    </td>
//                                    <td style="" class="edit-delete">
//                                        <button type="button" id="delete-users" class="btn btn-danger btn-sm my-3" data-id="'. $user->id .'">DELETE</button>
//                                        <a href="'. route('users.edit', $user->id) .'" class="btn btn-warning edit-btn d-flex justify-content-center align-items-center" data-id="'. $user->id .'">Edit</a>
//                                    </td>
//                                </tr>
//                            ';
//            }
//            return response()->json(['html' => $html]);
//        }
        $loginUser = Auth::user();
        $role = $loginUser->roles->first();
        if ($request->ajax()) {
            return DataTables::of(User::with('roles')->get())
                ->addColumn('image', function ($user) {
                return $user->imageUrl;})
                ->editColumn('hobbies' , function ($user) {
                    return json_decode($user->hobbies);
                })
                ->make(true);
        }
        return view('users.index', compact('users', 'role'));
    }
    public function create()
    {
        $user = Auth::user();
        $role = $user->roles->first();
//            if ($role->hasPermissionTo('create user')) {
                $roles = Role::all();
                return view('users.create' , compact('roles'));
//            }
//            else{
//                return redirect()->route('users.index')->with(['error' => "You don't have permission to create user."]);
//            }
    }
    public function store(CreateUserRequest  $request)
    {
        $input = $request->all();
        $role = Role::find($input['role']);
        $user = User::create([
            'first_name' => $input['firstName'],
            'last_name' => $input['lastName'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'hobbies' => json_encode($input['hobbie']),
            'gender' => $input['gender'],
            'image' => null,
        ]);
        if ($request->hasFile('image')) {
            $user->addMedia($input['image'])->toMediaCollection('users');
        }
        $user->syncRoles($role);
        $user->syncPermissions(Permission::pluck('name'));
        return response()->json(['success'=>'User create successfully.']);
    }
    public function edit(string $id)
    {
        $user = Auth::user();
        $role = $user->roles->first();
//        if ($role->hasPermissionTo('edit user')) {
                $user = User::find($id);
                $roles = Role::all();

                return view('users.edit', compact('user', 'roles'));
//        }
//        else{
//            return redirect()->route('users.index')->with(['error' => "You don't have permission to update user."]);
//        }

    }
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        $input = $request->all();
        $deleteImg = $user->getFirstMedia('users');
        if($request->hasFile('image')){
            $user->addMedia($input['image'])->toMediaCollection('users');
            if($deleteImg){
                $deleteImg->delete();
            }
        }
        $role = Role::find($input['role']);
        $user->update([
            'first_name' => $input['firstName'],
            'last_name' => $input['lastName'],
            'email' => $input['email'],
            'password' => $input['password'] == null ? $user->password : hash::make($input['password']),
            'hobbies' => json_encode($input['hobbie']),
            'gender' => $input['gender'],
            'image' => null,
        ]);
        if(isset($input['tag'])){
            $user->tags()->delete();
            foreach ($input['tag'] as $tag) {
                $user->tags()->create(['tag' => $tag]);
            }
        }
        $user->syncRoles($role);
        $user->syncPermissions(Permission::pluck('name'));
        return response()->json(['success'=>'User update successfully.']);
    }
    public function destroy(string $id)
    {
        $user = Auth::user();
        $role = $user->roles->first();
        if ($role->hasPermissionTo('delete user')) {
                $user = User::find($id);
                $user->delete();
                $deleteImg = $user->getFirstMedia('users');
                if($deleteImg)
                {
                    $deleteImg->delete();
                }
                return response()->json(['success' => 'User delete successfully.']);
        }
        else{
            return redirect()->route('users.index')->with(['error' => "You don't have permission to delete user."]);
        }
    }
    public function exports()
    {
        SendEmailUserData::dispatch();
    }
}
