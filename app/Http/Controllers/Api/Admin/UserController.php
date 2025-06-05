<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Resources\Api\Admin\UserResource;
use App\Models\User;
use App\Services\ResponseService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = User::with('profile')->where('is_admin', false)->get();

        return ResponseService::success(
            UserResource::collection($roles),
            'users retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        $role = User::create($validated);

        return ResponseService::success(
            new UserResource($role),
            'User created successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        // Check if the user ID is within a restricted list
        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to view this user',
                403
            );
        }

        // Ensure it's not an admin
        if ($user->is_admin) {
            return ResponseService::error(
                'User not found',
                404
            );
        }

        return ResponseService::success(
            new UserResource($user),
            'User retrieved successfully'
        );
    }

    public function activeUsers(User $user)
    {
        // Check if the user ID is within a restricted list
        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to view this user',
                403
            );
        }

        // Toggle the active status
        $user->is_active = ! $user->is_active;
        $user->save();

        return ResponseService::success(
            new UserResource($user),
            'User active status updated successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to update this user',
                403
            );
        }

        $validated = $request->validated();

        // Update user basic fields
        $user->update($validated);

        // Handle role assignment if provided
        if (isset($validated['role'])) {
            $user->syncRoles($validated['role']);
        }

        return ResponseService::success(
            new UserResource($user->load('roles')),
            'User updated successfully'
        );
    }

    public function updateActiveStatus(User $user)
    {
        return response()->json([
            'message' => 'User active status updated successfully',
        ]);
        $user->is_active = ! $user->active;
        $user->save();

        return ResponseService::success(
            new UserResource($user),
            'User active status updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return ResponseService::success(
            new UserResource($user),
            'User deleted successfully'
        );
    }

    public function trashed()
    {

        $user = User::onlyTrashed()->get();

        return ResponseService::success(
            UserResource::collection($user),
            'Trashed user fetched successfully'
        );
    }

    public function restore(User $user)
    {
        $user->restore();

        return ResponseService::success(
            new UserResource($user),
            'user restored successfully'
        );
    }

    public function forceDelete(User $user)
    {
        $user->forceDelete();

        return ResponseService::success('user permanently deleted');
    }
}
