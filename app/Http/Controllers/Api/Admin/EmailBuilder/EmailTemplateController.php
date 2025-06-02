<?php

namespace App\Http\Controllers\Api\Admin\EmailBuilder;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmailTempalte\StoreEmailTemplateRequest;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Storage;
use Shaz3e\EmailBuilder\App\Models\EmailTemplate;
use Shaz3e\EmailBuilder\Facades\EmailBuilder;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = EmailTemplate::all();

        return ResponseService::success(
            $templates,
            'Email templates retrieved successfully',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmailTemplateRequest $request)
    {
        $validated = $this->processRequest($request);

        $emailTemplate = EmailBuilder::addTemplate($validated);

        return ResponseService::success(
            $emailTemplate,
            'Email template created successfully',
            201
        );
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
    public function update(StoreEmailTemplateRequest $request, EmailTemplate $emailTemplate)
    {
        $validated = $this->processRequest($request);

        $emailTemplate = EmailBuilder::addTemplate($validated);

        return ResponseService::success(
            $emailTemplate,
            'Email template updated successfully',
            200
        );
    }

    private function processRequest(StoreEmailTemplateRequest $request, ?EmailTemplate $emailTemplate = null): array
    {
        $validated = $request->validated();

        // Handle images
        $validated = $this->handleImages($request, $validated, $emailTemplate);

        // Remove fields if header/footer not selected
        $validated = $this->filterFields($validated);

        return $validated;
    }

    private function handleImages(StoreEmailTemplateRequest $request, array $validated, ?EmailTemplate $emailTemplate = null): array
    {
        $imageFields = ['header_image', 'footer_image', 'footer_bottom_image'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // If updating, delete old image
                if ($emailTemplate && $emailTemplate->{$field}) {
                    Storage::disk('public')->delete($emailTemplate->{$field});
                }

                $validated[$field] = $request->file($field)->store('email-templates', 'public');
            }
        }

        return $validated;
    }

    private function filterFields(array $validated): array
    {
        if (empty($validated['header'])) {
            $validated['header_image'] = null;
            $validated['header_text'] = null;
            $validated['header_text_color'] = null;
            $validated['header_background_color'] = null;
        }

        if (empty($validated['footer'])) {
            $validated['footer_image'] = null;
            $validated['footer_text'] = null;
            $validated['footer_text_color'] = null;
            $validated['footer_background_color'] = null;
            $validated['footer_bottom_image'] = null;
        }

        return $validated;
    }
}
