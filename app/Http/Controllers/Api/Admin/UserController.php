<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUpdateUserPasswordRequest;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Resources\Api\Admin\UserResource;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizePermission('users.list');
        $users = User::with(['profile'])
            ->withTrashed()
            ->where('is_admin', false)
            ->where('id', '!=', Auth::id())
            ->get();

        return ResponseService::success(
            UserResource::collection($users),
            'Users retrieved successfully'
        );
    }

    public function store(UserStoreRequest $request)
    {
        // $this->authorizePermission('users.create');

        $validated = $request->validated();
        unset($validated['email_verified_at']);

        $validated['email_verified_at'] = $request->input('email_verified_at') === 'yes'
            ? now()
            : null;

        $user = User::create($validated);

        return ResponseService::success(
            new UserResource($user),
            'User created successfully'
        );
    }

    public function show(User $user)
    {
        /*   $this->authorizePermission('users.read'); */

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

        $user->load('profile');

        return ResponseService::success(
            new UserResource($user),
            'User retrieved successfully'
        );
    }

    public function toggleLocked(User $user)
    {
        $this->authorizePermission('users.update');

        $user->is_locked = ! $user->is_locked;
        $user->save();

        return ResponseService::success(new UserResource($user), 'Lock status updated.');
    }

    public function toggleSuspended(User $user)
    {
        $this->authorizePermission('users.update');

        $user->is_suspended = ! $user->is_suspended;
        $user->save();

        return ResponseService::success(new UserResource($user), 'Suspended status updated.');
    }

    public function update(UserUpdateRequest $req, string $id)
    {
        $validated = $req->validated();
        $user = User::with('profile')->findOrFail($id);

        $user->update($validated);

        if (! empty($validated['profile']) && is_array($validated['profile'])) {
            $user->profile()->updateOrCreate(
                [], // no need to specify columns
                $validated['profile']
            );
        }

        return ResponseService::success(
            new UserResource($user->load('profile')),
            'user updated successfully'
        );
    }

    public function destroy(User $user)
    {

        $this->authorizePermission('users.delete');

        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to delete this user',
                403
            );
        }

        $user->delete();

        return ResponseService::success(
            new UserResource($user),
            'User deleted successfully'
        );
    }

    public function trashed()
    {
        $this->authorizePermission('users.list');

        $users = User::onlyTrashed()->get();

        return ResponseService::success(
            UserResource::collection($users),
            'Trashed users fetched successfully'
        );
    }

    public function restore($userId)
    {
        $this->authorizePermission('users.restore');

        $user = User::withTrashed()->findOrFail($userId);

        if (! $user->trashed()) {
            return ResponseService::error('User is not deleted', 400);
        }

        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to restore this user',
                403
            );
        }

        $user->restore();

        return ResponseService::success(
            new UserResource($user),
            'User restored successfully'
        );
    }

    public function forceDelete($userId)
    {
        $this->authorizePermission('users.force.delete');

        $user = User::withTrashed()->findOrFail($userId);

        if (! $user->trashed()) {
            return ResponseService::error('User is not deleted', 400);
        }

        if (in_array($user->id, [1, 2, 3])) {
            return ResponseService::error(
                'You do not have permission to permanently delete this user',
                403
            );
        }

        $user->forceDelete();

        return ResponseService::success(
            'User permanently deleted'
        );
    }

    public function updatePassword(AdminUpdateUserPasswordRequest $request, User $user)
    {
        $this->authorizePermission('users.update');

        $validated = $request->validated();
        $user->update($validated);

        return ResponseService::success('Password updated successfully.');
    }

    protected function authorizePermission(string $permission)
    {
        if (! auth()->user()->can($permission)) {
            abort(403, 'Unauthorized.');
        }
    }
}
