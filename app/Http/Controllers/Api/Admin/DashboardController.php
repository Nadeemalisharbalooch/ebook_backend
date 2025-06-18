<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */


public function __invoke(Request $request)
{
    $stats = DB::table('users')
        ->selectRaw('COUNT(*) as total_users')
        ->selectRaw('SUM(is_active) as active_users')
        ->selectRaw('SUM(is_suspended) as suspended_users')
        ->selectRaw('SUM(is_locked) as locked_users')
        ->selectRaw('SUM(is_admin) as admin_users')
        ->selectRaw('SUM(!is_admin) as users')
        ->first();

    return ResponseService::success([
        'total_users'     => (int) $stats->total_users,
        'active_users'    => (int) $stats->active_users,
        'suspended' => (int) $stats->suspended_users,
        'locked_users'    => (int) $stats->locked_users,
        'Staffs'     => (int) $stats->admin_users,
        'Users'     => (int) $stats->users,
    ], 'User statistics retrieved successfully');
}


}
