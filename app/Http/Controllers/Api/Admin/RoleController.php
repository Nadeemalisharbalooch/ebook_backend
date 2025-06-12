<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Http\Resources\Api\Admin\RoleResource;
use App\Models\Role;
use App\Services\ResponseService;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withTrashed()->get(); // include trashed + eager load permissions

        return ResponseService::success(
            RoleResource::collection($roles),
            'All roles including trashed retrieved successfully'
        );
    }

    public function show(Role $role)
    {

        return ResponseService::success(
            new RoleResource($role),
            'Role retrieved successfully'
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();

        $role = Role::create($validated);

        return ResponseService::success(
            new RoleResource($role),
            'Role created successfully'
        );
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        $role->update($validated);

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return ResponseService::success(
            new RoleResource($role->load('permissions')),
            'Role updated successfully'
        );
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return ResponseService::success(
            new RoleResource($role),
            'Role deleted successfully'
        );
    }

    public function trashed()
    {
        $roles = Role::onlyTrashed()->get();

        return ResponseService::success(
            RoleResource::collection($roles),
            'Trashed roles fetched successfully'
        );
    }

    public function restore($roleId)
    {
        $role = Role::withTrashed()->findOrFail($roleId);

        // Check if actually trashed
        if (! $role->trashed()) {
            return ResponseService::error('role is not deleted', 400);
        }

        // Restore the rol$role
        $role->restore();

        return ResponseService::success(
            new RoleResource($role),
            'role restored successfully'
        );
    }

    public function forceDelete(string $role)
    {
        $role = Role::withTrashed()->findOrFail($role);

        // check if user is trached otherwise throw error
        if (! $role->trashed()) {
            return ResponseService::error('role is not deleted', 400);
        }

        // Permanently delete
        $role->forceDelete();

        return ResponseService::success(
            'Role permanently deleted'
        );
    }
}
