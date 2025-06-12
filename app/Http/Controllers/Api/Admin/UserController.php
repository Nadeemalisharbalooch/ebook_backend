<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUpdateUserPasswordRequest;
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
        $roles = User::with(['profile'])
            ->withTrashed() // include trashed users
            ->where('is_admin', false)
            ->get();

        return ResponseService::success(
            UserResource::collection($roles),
            'Users retrieved successfully'
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {

        $validated = $request->validated();

        unset($validated['email_verified_at']);

        // Step 3: set based on is_email_verified
        if ($request->input('email_verified_at') === 'yes') {
            $validated['email_verified_at'] = now();
        } else {
            $validated['email_verified_at'] = null;
        }

        // Step 4: create user
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
        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to view this user',
                403
            );
        }

        if ($user->is_admin) {
            return ResponseService::error(
                'User not found',
                404
            );
        }

        // Load the profile relationship
        $user->load('profile');

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
        $user = User::with('profile')->findOrFail($id);

        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to update this user',
                403
            );
        }

        $validated = $request->validated();

        // Update user basic fields
        $user->update($validated);

        // Update profile fields if present
        if (isset($validated['profile']) && is_array($validated['profile'])) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $validated['profile']
            );
        }

        // Handle role assignment if provided
        if (isset($validated['role'])) {
            $user->syncRoles($validated['role']);
        }

        return ResponseService::success(
            new UserResource($user->load(['roles', 'profile'])),
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

    public function restore($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);

        // Check if actually trashed
        if (! $user->trashed()) {
            return ResponseService::error('User is not deleted', 400);
        }

        // Restore the user
        $user->restore();

        return ResponseService::success(
            new UserResource($user),
            'User restored successfully'
        );
    }

    public function forceDelete($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);

        // Permanently delete
        $user->forceDelete();

        return ResponseService::success(
            'User permanently deleted'
        );
    }

    public function updatePassword(AdminUpdateUserPasswordRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update($validated);

        return ResponseService::success('Password updated successfully.');
    }
}
