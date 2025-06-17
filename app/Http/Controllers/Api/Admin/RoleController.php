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
        $this->authorizePermission('roles.list');
        $roles = Role::withTrashed()->get();

        return ResponseService::success(
            RoleResource::collection($roles),
            'All roles including trashed retrieved successfully'
        );
    }

    public function show(Role $role)
    {
        $this->authorizePermission('roles.read');
        $role->load('permissions');

        return ResponseService::success(
            new RoleResource($role),
            'Role retrieved successfully'
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $this->authorizePermission('roles.create');
        $validated = $request->validated();

        $role = Role::create($validated);

        return ResponseService::success(
            new RoleResource($role),
            'Role created successfully'
        );
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorizePermission('roles.update');
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

    public function toggleActive(Role $role)
    {
        $this->authorizePermission('roles.update');
        $role->is_active = ! $role->is_active;
        $role->save();

        return ResponseService::success(new RoleResource($role), 'Active status updated.');
    }

    public function destroy(Role $role)
    {
        $this->authorizePermission('roles.delete');
        $role->delete();

        return ResponseService::success(
            new RoleResource($role),
            'Role deleted successfully'
        );
    }

    public function trashed()
    {
        $this->authorizePermission('roles.list');
        $roles = Role::onlyTrashed()->get();

        return ResponseService::success(
            RoleResource::collection($roles),
            'Trashed roles fetched successfully'
        );
    }

    public function restore($roleId)
    {
        $this->authorizePermission('roles.restore');
        $role = Role::withTrashed()->findOrFail($roleId);

        if (! $role->trashed()) {
            return ResponseService::error('Role is not deleted', 400);
        }

        $role->restore();

        return ResponseService::success(
            new RoleResource($role),
            'Role restored successfully'
        );
    }

    public function forceDelete(string $role)
    {
        $this->authorizePermission('roles.force.delete');
        $role = Role::withTrashed()->findOrFail($role);

        if (! $role->trashed()) {
            return ResponseService::error('Role is not deleted', 400);
        }

        $role->forceDelete();

        return ResponseService::success(
            'Role permanently deleted'
        );
    }

    protected function authorizePermission(string $permission)
    {
        if (! auth()->user()->can($permission)) {
            abort(403, 'Unauthorized.');
        }
    }
}
