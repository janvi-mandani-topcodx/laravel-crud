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
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $users = User::where('first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('hobbies', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%')
                ->get();
        }
        else{
            $users = User::all();
        }
        if ($request->ajax()) {
            $html = '';
            foreach ($users as $user) {
                $html .= '  <tr id="oneUser" data-id="'. $user->id .'">
                                    <td>'. $user->id .'</td>
                                    <td>'. $user->first_name.'</td>
                                    <td>'. $user->last_name .'</td>
                                    <td>'. $user->email .'</td>
                                    <td>'. implode(',', json_decode($user->hobbies)).'</td>
                                    <td>'. $user->gender.'</td>
                                    <td>
                                        <img class="img-fluid img-thumbnail" src="'. $user->imageUrl .'" alt="Uploaded Image" width="200" style="height: 126px;">
                                    </td>
                                    <td style="" class="editDelete">
                                        <form action="'. route('users.destroy', $user->id) .'" method="POST">
                                           '. @csrf_field() .'
                                            '. method_field('DELETE') .'
                                            <button type="button" id="deleteUsers" class="btn btn-danger btn-sm my-3" data-id="'. $user->id .'">DELETE</button>
                                        </form>
                                        <a href="'. route('users.edit', $user->id) .'" class="btn btn-warning editbtn d-flex justify-content-center align-items-center" data-id="'. $user->id .'">Edit</a>
                                    </td>
                                </tr>
                            ';
            }
            return response()->json(['html' => $html]);
        }

        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(CreateUserRequest  $request)
    {
        $input = $request->all();
        if($request->hasFile('image')){
            $path = $input['image']->store('images', 'public');
        }
        else{
            $path = $input['image'];
        }
        $user = User::create([
            'first_name' => $input['firstName'],
            'last_name' => $input['lastName'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'hobbies' => json_encode($input['hobbie']),
            'gender' => $input['gender'],
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
        $input = $request->all();
        if($request->hasFile('image')){
            $path = $input['image']->store('images', 'public');
            if($user->image){
                Storage::disk('public')->delete($user->image);
            }
        } else{
            $path = $user->image;
        }

        $user->update([
            'first_name' => $input['firstName'],
            'last_name' => $input['lastName'],
            'email' => $input['email'],
            'password' => $input['password'] == null ? $user->password : hash::make($input['password']),
            'hobbies' => json_encode($input['hobbie']),
            'gender' => $input['gender'],
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

}
