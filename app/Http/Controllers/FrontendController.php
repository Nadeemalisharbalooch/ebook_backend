<?php

namespace App\Http\Controllers;

use App\Http\Resources\Api\Vendor\BookResource;
use App\Models\Book;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate(10);
        return ResponseService::success(
            BookResource::collection($books),
            'Books retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return ResponseService::error('You cannot delete your own account', 403);
        }

        if ($user->is_admin) {
            return ResponseService::error('You cannot delete an admin user', 403);
        }


        $user->delete();

        return ResponseService::success(
            new StaffUserResource($user),
            'Staff User deleted successfully'
        );
    }


     public function trashed()
    {

        $users = User::onlyTrashed()->get();

        return ResponseService::success(
            StaffUserResource::collection($users),
            'Trashed users fetched successfully'
        );
    }

      public function restore(User $user)
    {

        $user->restore();

        return ResponseService::success(
            new StaffUserResource($user),
            'Staff user restored successfully'
        );
    }

     public function forceDelete($userId)
    {

        $user = User::withTrashed()->findOrFail($userId);

        // Permanently delete
        $user->forceDelete();

        return ResponseService::success(
            'User permanently deleted'
        );
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
}
