<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUpdateUserPasswordRequest;
use App\Http\Requests\Admin\StoreStaffUserRequest;
use App\Http\Requests\Admin\UpdateStaffUserRequest;
use App\Http\Resources\Api\Admin\StaffUserResource;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Services\ResponseService;

class StaffUserController extends Controller
{
    public function index()
    {
        $users = User::with(['profile'])
            ->withTrashed()
            ->where('is_admin', true)
            ->where('id', '!=',  Auth::id())
            ->get();

        return ResponseService::success(
            StaffUserResource::collection($users),
            'Users retrieved successfully'
        );
    }


    public function store(StoreStaffUserRequest $request)
    {
        /** @var Request $request */
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

    public function show($id)
    {
        $user = User::with(['roles', 'profile'])->find($id);

        if (! $user) {
            return ResponseService::error('User not found', 404);
        }

        return ResponseService::success(
            new StaffUserResource($user),
            'User retrieved successfully'
        );
    }

    public function update(UpdateStaffUserRequest $request, string $id)
    {
        $validated = $request->validated();

        // Find the user with profile
        $user = User::with('profile')->findOrFail($id);

        // Update basic user data
        $user->update($validated);

        // Update profile if profile data is sent
        if (isset($validated['profile']) && is_array($validated['profile'])) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $validated['profile']
            );
        }

        // Handle role assignment
        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        return ResponseService::success(
            new StaffUserResource($user->load(['roles', 'profile'])),
            'Staff user updated successfully'
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

    public function updatePassword(AdminUpdateUserPasswordRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update($validated);

        return ResponseService::success('Password updated successfully.');
    }
}
