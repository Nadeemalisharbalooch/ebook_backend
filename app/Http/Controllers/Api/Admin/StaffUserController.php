<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUpdateUserPasswordRequest;
use App\Http\Requests\Admin\StoreStaffUserRequest;
use App\Http\Requests\Admin\UpdateStaffUserRequest;
use App\Http\Resources\Api\Admin\StaffUserResource;
use App\Models\Permission;
use App\Models\User;

use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaffUserController extends Controller
{
    public function index()
    {

        $this->authorizePermission('clients.list');

        $users = User::with(['profile'])
            ->withTrashed()
            ->where('is_admin', true)
            ->where('id', '!=', Auth::id())
            ->get();

        return ResponseService::success(
            StaffUserResource::collection($users),
            'Users retrieved successfully'
        );
    }


    public function store(StoreStaffUserRequest $request)
    {
        $this->authorizePermission('clients.create');

        $validated = $request->validated();

        unset($validated['email_verified_at']);

        $validated['email_verified_at'] = $request->input('email_verified_at') === 'yes'
            ? now()
            : null;

        $user = User::create($validated);

        return ResponseService::success(
            new StaffUserResource($user),
            'Staff User created successfully'
        );
    }

    public function show($id)
    {
        $this->authorizePermission('clients.read');


        $user = User::with(['roles', 'profile'])->find($id);

        if (!$user) {
            return ResponseService::error('User not found', 404);
        }


        return ResponseService::success(
            new StaffUserResource($user),
            'User retrieved successfully'
        );
    }

 public function update(UpdateStaffUserRequest $request, string $id)
{
    $user = User::with('profile')->findOrFail($id);
    $data = $request->validated();

    // Handle avatar upload
    if ($request->hasFile('profile.avatar_file')) {
        // Delete old avatar if exists
        if ($user->profile?->avatar) {
            Storage::disk('public')->delete('avatars/'.$user->profile->avatar);
        }

        // Store new avatar
        $filename = $request->file('profile.avatar_file')->store('avatars', 'public');
        $data['profile']['avatar'] = basename($filename);
    }

    // Update user
    $user->update($data);

    // Update profile
    if (isset($data['profile'])) {
        $user->profile()->update(
            ['user_id' => $user->id],
            $data['profile']
        );
    }

    // Sync roles
    if (isset($data['roles'])) {
        $user->syncRoles($data['roles']);
    }

    return ResponseService::success(
        new StaffUserResource($user->fresh(['roles', 'profile'])),
        'Staff updated successfully'
    );
}


    public function destroy(User $user)
    {
        $this->authorizePermission('clients.delete');

        $user->delete();

        return ResponseService::success(
            new StaffUserResource($user),
            'Staff User deleted successfully'
        );
    }

    public function trashed()
    {
        $this->authorizePermission('clients.list');

        $users = User::onlyTrashed()->get();

        return ResponseService::success(
            StaffUserResource::collection($users),
            'Trashed users fetched successfully'
        );
    }

    public function restore(User $user)
    {
        $this->authorizePermission('clients.restore');

        $user->restore();

        return ResponseService::success(
            new StaffUserResource($user),
            'Staff user restored successfully'
        );
    }

     public function forceDelete($userId)
        {
             $this->authorizePermission('clients.force.delete');
            $user = User::withTrashed()->findOrFail($userId);

            // Permanently delete
            $user->forceDelete();

            return ResponseService::success(
                'User permanently deleted'
            );
        }

    public function updatePassword(AdminUpdateUserPasswordRequest $request, User $user)
    {
        $this->authorizePermission('clients.password.update');

        $validated = $request->validated();
        $user->update($validated);

        return ResponseService::success('Password updated successfully.');
    }

    public function email_verified(User $user)
    {
        $user->email_verified_at = $user->email_verified_at ? null : now();
        $user->save();

        return ResponseService::success(new StaffUserResource($user), 'Lock status updated.');
    }
    public function toggleLocked(User $user)
    {
        $user->is_locked = ! $user->is_locked;
        $user->save();

        return ResponseService::success(new StaffUserResource($user), 'Lock status updated.');
    }

    public function toggleActive(User $user)
    {
        $user->is_active = ! $user->is_active;
        $user->save();

        return ResponseService::success(
            new StaffUserResource($user),
            'User active status updated successfully'
        );
    }

    public function toggleSuspended(User $user)
    {
        $user->is_suspended = ! $user->is_suspended;
        $user->save();

        return ResponseService::success(new StaffUserResource($user), 'Suspended status updated.');
    }

    protected function authorizePermission(string $permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized.');
        }
    }
}
