<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function view(Request $request)
    {
        return $request->user();
    }

    public function store(Request $request)
    {
        // Update the user's profile
    }
}
