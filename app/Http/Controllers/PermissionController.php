<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index' ,compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->permission
        ]);

        return response()->json([
            'id' => $permission->id,
            'name' => $permission->name
        ]);
    }


    public function show(string $id)
    {

    }

    public function edit(string $id)
    {

    }


    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $request->permission;
        $permission->save();
        return response()->json([
            'id' => $permission->id,
            'permission' => $permission->name
        ]);
    }

    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json(['success' => true]);
    }
}
