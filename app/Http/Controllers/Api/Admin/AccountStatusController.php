<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\UserResource;
use App\Models\User;
use App\Services\ResponseService;

class AccountStatusController extends Controller
{
    //

    public function toggleActive(User $user)
    {
        $user->is_active = ! $user->is_active;
        $user->save();

        return ResponseService::success(new UserResource($user), 'Active status updated.');
    }

    /**
     * Toggle the lock status of a user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleLocked(User $user)
    {
        $user->is_locked = ! $user->is_locked;
        $user->save();

        return ResponseService::success(new UserResource($user), 'Lock status updated.');
    }

    public function toggleSuspended(User $user)
    {
        $user->is_suspended = ! $user->is_suspended;
        $user->save();

        return ResponseService::success(new UserResource($user), 'Suspended status updated.');
    }
}
