<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\BookResource;
use App\Models\Book;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::withTrashed()->get();

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
        $book = Book::create($request->validated());

        return ResponseService::success(
            new BookResource($book),
            'Book created successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        return ResponseService::success(
            new BookResource($book),
            'Book retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::withTrashed()->findOrFail($id);
        $book->update($request->validated());

        return ResponseService::success(
            new BookResource($book),
            'Book updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        if ($book->is_admin) {
            return ResponseService::error('You cannot delete an admin book', 403);
        }

        if ($user->is_admin) {
            return ResponseService::error('You cannot delete an admin user', 403);
        }

        $book->delete();

        return ResponseService::success(
            new BookResource($book),
            'Book deleted successfully'
        );
    }

    public function trashed()
    {

        $books = Book::onlyTrashed()->get();

        return ResponseService::success(
            BookResource::collection($books),
            'Trashed books fetched successfully'
        );
    }

    public function restore(Book $book)
    {

        $book->restore();

        return ResponseService::success(
            new BookResource($book),
            'Book restored successfully'
        );
    }

    public function forceDelete($bookId)
    {

        $book = Book::withTrashed()->findOrFail($bookId);

        // Permanently delete
        $book->forceDelete();

        return ResponseService::success(
            'Book permanently deleted'
        );
    }

    public function toggleActive(Book $book)
    {
        $book->is_active = ! $book->is_active;
        $book->save();

        return ResponseService::success(
            new BookResource($book),
            'Book active status updated successfully'
        );
    }
}
