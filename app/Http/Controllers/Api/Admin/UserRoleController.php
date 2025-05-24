<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\ResponseService;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);
        $user->assignRole($request->role);

        return ResponseService::success(
            null,
            'Role assigned successfully.'
        );
    }

    public function removeRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);
        $user->removeRole($request->role);

        return ResponseService::success(
            null,
            'Role removed successfully.'
        );
    }

    public function syncRoles(Request $request, $userId)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user = User::findOrFail($userId);
        $user->syncRoles($request->roles);

        return ResponseService::success(
            null,
            'Roles synced successfully.'
        );
    }
}
