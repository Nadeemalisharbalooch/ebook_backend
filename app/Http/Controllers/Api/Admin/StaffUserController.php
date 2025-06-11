<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStaffUserRequest;
use App\Http\Requests\Admin\UpdateStaffUserRequest;
use App\Http\Resources\Api\Admin\StaffUserResource;
use App\Models\User;
use App\Services\ResponseService;

class StaffUserController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->where('is_admin', true)->get();

        return ResponseService::success(
            StaffUserResource::collection($users),
            ' Staff users retrieved successfully'
        );
    }

    public function store(StoreStaffUserRequest $request)
    {
        $validated = $request->validated();

        unset($validated['email_verified_at']);

        if ($request->input('email_verified_at') === 'yes') {
            $validated['email_verified_at'] = now();
        } else {
            $validated['email_verified_at'] = null;
        }

        $role = User::create($validated);

        return ResponseService::success(
            new StaffUserResource($role),
            'Staff User created successfully'
        );
    }

    public function show(User $user)
    {
        // Check if the user ID is within a restricted list
        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to view this user',
                403
            );
        }

        return ResponseService::success(
            new StaffUserResource($user->load('roles')),
            ' Staff User retrieved successfully'
        );
    }

    public function update(UpdateStaffUserRequest $request, string $id)
    {

        $validated = $request->validated();

        //  Find the user
        $user = User::findOrFail($id);

        //  Update basic user data
        $user->update($validated);

        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        return ResponseService::success(
            new StaffUserResource($user->load('roles')),
            ' Staff User updated successfully'
        );
    }

    public function destroy(User $user)
    {

        $user->delete();

        return ResponseService::success(
            new StaffUserResource($user),
            'Staff User deleted successfully'
        );
    }

    public function trashed()
    {
        $user = User::onlyTrashed()->get();

        return ResponseService::success(
            StaffUserResource::collection($user),
            'Trashed user fetched successfully'
        );
    }

    public function restore(User $user)
    {
        $user->restore();

        return ResponseService::success(
            new StaffUserResource($user),
            ' Staff user restored successfully'
        );
    }
}
