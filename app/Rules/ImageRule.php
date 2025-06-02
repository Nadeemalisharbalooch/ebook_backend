<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ImageRule implements ValidationRule
{
    protected int $maxSize; // in kilobytes (KB)

    /**
     * Create a new rule instance.
     *
     * @param  int  $maxSize  Maximum file size in kilobytes (default 2048 KB = 2MB)
     */
    public function __construct($maxSize = null)
    {
        $this->maxSize = $maxSize ?? config('email-builder.image.max_size');
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // change $attribute to human readable
        $attribute = str_replace('_', ' ', ucwords($attribute));

        // Check if it is a file and an instance of UploadedFile
        if (! $value instanceof UploadedFile) {
            $fail("The {$attribute} must be a valid file.");

            return;
        }

        // Check if the file is an image
        if (! str_starts_with($value->getMimeType(), 'image/')) {
            $fail("The {$attribute} must be an image.");

            return;
        }

        // Check allowed extensions
        $allowedExtensions = config('email-builder.image.allowed_extensions');
        $extension = strtolower($value->getClientOriginalExtension());

        if (! in_array($extension, $allowedExtensions)) {
            $fail("The {$attribute} must be a file of type: ".implode(', ', $allowedExtensions).'.');

            return;
        }

        // Check file size (UploadedFile::getSize() returns bytes)
        if ($value->getSize() / 1024 > $this->maxSize) {
            $fail("The {$attribute} must not be larger than {$this->maxSize} KB.");

            return;
        }
    }
}
