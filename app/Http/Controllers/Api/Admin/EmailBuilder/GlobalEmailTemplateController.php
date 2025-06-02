<?php

namespace App\Http\Controllers\Api\Admin\EmailBuilder;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmailTempalte\StoreGlobalEmailTemplateRequest;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Storage;
use Shaz3e\EmailBuilder\App\Models\GlobalEmailTemplate;

class GlobalEmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $globalEmailTemplate = GlobalEmailTemplate::first();

        return ResponseService::success(
            $globalEmailTemplate,
            'Global email template retrieved successfully',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGlobalEmailTemplateRequest $request)
    {
        $validated = $request->validated();

        $globalEmailTemplate = GlobalEmailTemplate::first();

        // First delete images and then Upload images
        if ($request->hasFile('header_image')) {
            // Delete old image
            if ($globalEmailTemplate->header_image) {
                Storage::disk('public')->delete($globalEmailTemplate->header_image);
            }
            $validated['header_image'] = $request->file('header_image')
                ->store('global-email-templates', 'public');
        }
        if ($request->hasFile('footer_image')) {
            // Delete old image
            if ($globalEmailTemplate->footer_image) {
                Storage::disk('public')->delete($globalEmailTemplate->footer_image);
            }
            $validated['footer_image'] = $request->file('footer_image')
                ->store('global-email-templates', 'public');
        }
        if ($request->hasFile('footer_bottom_image')) {
            // Delete old image
            if ($globalEmailTemplate->footer_bottom_image) {
                Storage::disk('public')->delete($globalEmailTemplate->footer_bottom_image);
            }
            $validated['footer_bottom_image'] = $request->file('footer_bottom_image')
                ->store('global-email-templates', 'public');
        }

        $globalEmailTemplate->update($validated);

        return ResponseService::success(
            $globalEmailTemplate,
            'Global email template updated successfully',
            200
        );
    }
}
