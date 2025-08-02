<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
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
            ->selectRaw('COUNT(*) AS total_users')
            ->selectRaw('SUM(is_active) AS active_users')
            ->selectRaw('SUM(is_suspended) AS suspended_users')
            ->selectRaw('SUM(is_locked) AS locked_users')
            ->selectRaw('SUM(is_admin) AS staff_users')
            ->selectRaw('SUM(is_admin = 0) AS normal_users')
            ->selectRaw('SUM(deleted_at IS NOT NULL) AS deleted_users')
            ->first();

        return ResponseService::success([
            'total_users' => (int) $stats->total_users,
            'active_users' => (int) $stats->active_users,
            'suspended' => (int) $stats->suspended_users,
            'locked_users' => (int) $stats->locked_users,
            'staff_users' => (int) $stats->staff_users,
            'normal_users' => (int) $stats->normal_users,
            'deleted_users' => (int) $stats->deleted_users,
        ], 'User statistics retrieved successfully');
    }
}
