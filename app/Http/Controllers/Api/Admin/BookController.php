<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\BookRequest;
use App\Http\Requests\Vendor\BookUpdateRequest;
use App\Http\Resources\Api\Vendor\BookResource;
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
    public function store(BookRequest $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->validated();
        $data['user_id'] = $user_id;
        // Handle Cover Image (single)
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Handle Multiple Images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('books/images', 'public');
            }
            $data['images'] = $images;
        }

        $book = Book::create($data);
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
        $book->load('subCategory.category', 'user');
           return ResponseService::success(
            new BookResource($book),
            'Book retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        $data = $request->validated();

        // User ID hamesha login user ka hoga
        $data['user_id'] = auth()->id();

        // Handle Cover Image (replace only if new file given)
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Handle Multiple Images (replace only if new files given)
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('books/images', 'public');
            }
            $data['images'] = $images;
        }

        $book->update($data);

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

        $book->delete();

        return ResponseService::success(
            'Book deleted successfully'
        );
    }

    public function test(){
        return response()->json(['message' => 'Test endpoint working']);
    }

    public function trashed()
    {
        return response()->json(['message' => 'This endpoint is deprecated. Use index() method with withTrashed() instead.'], 410);
        $books = Book::onlyTrashed()->get();

        return ResponseService::success(
            BookResource::collection($books),
            'Trashed books fetched successfully'
        );
    }

    public function restore(string $bookId)
    {
         $book = Book::withTrashed()->findOrFail($bookId);
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
