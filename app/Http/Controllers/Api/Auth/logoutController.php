<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class logoutController extends Controller
{
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ResponseService::success(null, 'Logged out successfully.');
    }
}
