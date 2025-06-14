<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\PermissionResource;
use App\Models\Permission;
use App\Services\ResponseService;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return ResponseService::success(
            PermissionResource::collection($permissions),
            'All Permissions retrieved successfully'
        );
    }
}
