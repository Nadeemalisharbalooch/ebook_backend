<?php

namespace App\Services;

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailBuilderService
{
    /**
     * Send email using a template key and dynamic data
     */
    public function sendEmailBykey(string $key, string $to, array $data = []): bool
    {
        $template = EmailTemplate::where('key', $key)->first();

        if (! $template) {
            Log::warning("Email template with key [$key] not found.");

            return false;
        }

        // Replace placeholders in subject and body
        $subject = $this->replacePlaceholders($template->subject, $data);
        $body = $this->replacePlaceholders($template->body, $data);

        // Compose full email body with optional header and footer
        $fullBody = "<div style='font-family: Arial, sans-serif; background-color: #f9f9f9;'>";

        if ($template->header) {
            $fullBody .= $this->buildHeader($template);
        }

        $fullBody .= "
            <div style='padding: 20px; background: #ffffff; color: #333; font-size: 15px; line-height: 1.6;'>
                $body
            </div>
        ";

        if ($template->footer) {
            $fullBody .= $this->buildFooter($template);
        }

        $fullBody .= '</div>';

        // Send the email
        Mail::html($fullBody, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });

        return true;
    }

    /**
     * Replace placeholders like {{ name }}, {{app_name}}, {name} etc. with dynamic data
     */
    protected function replacePlaceholders(string $content, array $data): string
    {
        foreach ($data as $key => $value) {
            $content = str_replace(
                ['{{ '.$key.' }}', '{{'.$key.'}}', '{'.$key.'}'],
                $value,
                $content
            );
        }

        return $content;
    }

    /**
     * Build the email header section
     */
    protected function buildHeader($template): string
    {
        return "
            <div style='background: {$template->header_background_color}; color: {$template->header_text_color}; padding: 20px; text-align: center;'>
                ".($template->header_image ? "<img src='{$template->header_image}' alt='Header' style='max-height: 80px; margin-bottom: 10px;'>" : '')."
                <h2 style='margin: 0;'>{$template->header_text}</h2>
            </div>
        ";
    }

    /**
     * Build the email footer section
     */
    protected function buildFooter($template): string
    {
        return "
            <div style='background: {$template->footer_background_color}; color: {$template->footer_text_color}; padding: 20px; text-align: center; font-size: 13px;'>
                ".($template->footer_image ? "<img src='{$template->footer_image}' alt='Footer' style='max-height: 60px; margin-bottom: 10px;'>" : '')."
                <p style='margin: 0 0 10px;'>{$template->footer_text}</p>
                ".($template->footer_bottom_image ? "<img src='{$template->footer_bottom_image}' alt='Bottom Footer' style='max-height: 40px;'>" : '').'
            </div>
        ';
    }
}
