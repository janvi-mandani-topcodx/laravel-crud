<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('roles.index' ,compact('roles'));
    }



    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create' , compact('permissions'));
    }

    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();
        $permissions = $input['permission'];
        $role = Role::create([
            'name' => $input['role'],
        ]);
        $role->permissions()->sync($permissions);

        return response()->json(['success'=>'Role create successfully.']);
    }

    public function show(string $id)
    {

    }


    public function edit(string $id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role' , 'permissions'));
    }

    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $input = $request->all();
        $permissions = $input['permission'];
        $role->update([
            'name' => $input['role'],
        ]);
        $role->permissions()->sync($permissions);
        return response()->json(['success'=>'Role update successfully.']);
    }


    public function destroy(string $id)
    {
        $user = Role::find($id);
        $user->delete();
        return response()->json(['success'=>'Role delete successfully.']);
    }
}
