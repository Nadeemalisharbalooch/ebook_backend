<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array|nullable',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json(['message' => 'Role created successfully', 'role' => $role]);
    }


    /**
     * Display the specified resource.
     */
  public function show($id)
{
    $role = Role::with('permissions')->findOrFail($id);
    return response()->json($role);
}


    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $request->validate([
        'name' => 'required|unique:roles,name,' . $role->id,
        'permissions' => 'array|nullable',
    ]);

    $role->update(['name' => $request->name]);

    if ($request->has('permissions')) {
        $role->syncPermissions($request->permissions);
    }

    return response()->json(['message' => 'Role updated successfully']);
}


    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    $role = Role::findOrFail($id);
    $role->delete();

    return response()->json(['message' => 'Role deleted successfully']);
}

}
