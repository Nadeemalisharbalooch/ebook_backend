<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Http\Resources\Api\Admin\CategoryResource;
use App\Models\Category;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;

class CatergoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withTrashed()->get();
        return ResponseService::success(
            CategoryResource::collection($categories),
            'Categories retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return ResponseService::success(
            new CategoryResource($category),
            'Category created successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = Category::withTrashed()->findOrFail($id);

        return ResponseService::success(
            new CategoryResource($category),
            'Category retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->update($request->validated());

        return ResponseService::success(
            new CategoryResource($category),
            'Category updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->id === Auth::id()) {
            return ResponseService::error('You cannot delete your own account', 403);
        }

        if ($category->is_admin) {
            return ResponseService::error('You cannot delete an admin user', 403);
        }

        $category->delete();

        return ResponseService::success(
            new CategoryResource($category),
            'Category deleted successfully'
        );
    }

    public function trashed()
    {

        $categories = Category::onlyTrashed()->get();

        return ResponseService::success(
            CategoryResource::collection($categories),
            'Trashed categories fetched successfully'
        );
    }

    public function restore(Category $category)
    {

        $category->restore();

        return ResponseService::success(
            new CategoryResource($category),
            'Category restored successfully'
        );
    }

    public function forceDelete($categoryId)
    {

        $category = Category::withTrashed()->findOrFail($categoryId);

        // Permanently delete
        $category->forceDelete();

        return ResponseService::success(
            'category permanently deleted'
        );
    }

    public function toggleActive(Category $category)
    {
        $category->is_active = ! $category->is_active;
        $category->save();

        return ResponseService::success(
            new CategoryResource($category),
            'Category active status updated successfully'
        );
    }
}
