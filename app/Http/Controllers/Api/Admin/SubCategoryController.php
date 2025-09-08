<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreSubCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateSubCategoryRequest;
use App\Http\Resources\Api\Admin\SubCategoryResource;
use App\Models\SubCategory;
use App\Services\ResponseService;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $subCategories = SubCategory::withTrashed()->get();

        return ResponseService::success(
            SubCategoryResource::collection($subCategories),
            'Subcategories retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $subCategory = SubCategory::create($request->validated());

        return ResponseService::success(
            new SubCategoryResource($subCategory),
            'Subcategory created successfully',
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subCategory = SubCategory::withTrashed()->findOrFail($id);

        return ResponseService::success(
            new SubCategoryResource($subCategory),
            'Subcategory retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, string $id)
    {
        $subCategory = SubCategory::withTrashed()->findOrFail($id);
        $subCategory->update($request->validated());

        return ResponseService::success(
            new SubCategoryResource($subCategory),
            'Subcategory updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::withTrashed()->findOrFail($id);

        if ($subCategory->id === Auth::id()) {
            return ResponseService::error('You cannot delete your own account', 403);
        }

        if ($subCategory->is_admin) {
            return ResponseService::error('You cannot delete an admin user', 403);
        }

        $subCategory->delete();

        return ResponseService::success(
            new SubCategoryResource($subCategory),
            'Subcategory deleted successfully'
        );
    }

    public function trashed()
    {

        $subCategories = SubCategory::onlyTrashed()->get();

        return ResponseService::success(
            SubCategoryResource::collection($subCategories),
            'Trashed subcategories fetched successfully'
        );
    }

    public function restore(SubCategory $subCategory)
    {

        $subCategory->restore();

        return ResponseService::success(
            new SubCategoryResource($subCategory),
            'Subcategory restored successfully'
        );
    }

    public function forceDelete($subCategoryId)
    {

        $subCategory = SubCategory::withTrashed()->findOrFail($subCategoryId);

        // Permanently delete
        $subCategory->forceDelete();

        return ResponseService::success(
            'Subcategory permanently deleted'
        );
    }

    public function toggleActive(SubCategory $subCategory)
    {
        $subCategory->is_active = ! $subCategory->is_active;
        $subCategory->save();

        return ResponseService::success(
            new SubCategoryResource($subCategory),
            'Subcategory active status updated successfully'
        );
    }

    public function getSubcategories($id)
    {
        return "data has een ";
       return $subCategories = SubCategory::where('category_id', $id)->where('is_active', true)->get();

        return ResponseService::success(
            SubCategoryResource::collection($subCategories),
            'Subcategories retrieved successfully'
        );
    }
}
