<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\PermissionResource;
use App\Models\Permission;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseService::success(
            PermissionResource::collection(Permission::all()),
            'Permissions fetched successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'api',
        ]);

        return ResponseService::success(
            new PermissionResource($permission),
            'Permission created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return ResponseService::success(
            new PermissionResource($permission),
            'Permission fetched successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,'.$id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return ResponseService::success(
            new PermissionResource($permission),
            'Permission updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return ResponseService::success(
            null,
            'Permission deleted successfully.'
        );
    }
}
