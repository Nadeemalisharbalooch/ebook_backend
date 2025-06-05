<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email_templates = [
            ['id' => '1', 'header_image' => null, 'header_text' => null, 'header_text_color' => '#000000', 'header_background_color' => '#000000', 'footer_image' => null, 'footer_text' => null, 'footer_text_color' => null, 'footer_background_color' => null, 'footer_bottom_image' => null, 'key' => 'welcome_email', 'name' => 'Welcome Email', 'subject' => 'Welcome Email {app_name}', 'body' => 'Dear {name},

                    Thank you for registering {app_name}

                    Please verify your email.

                    Regards,
                    {app_name}', 'placeholders' => '["app_name", "name"]', 'header' => '0', 'footer' => '0', 'deleted_at' => null, 'created_at' => '2025-06-04 18:02:55', 'updated_at' => '2025-06-04 18:03:27'],
            ['id' => '2', 'header_image' => null, 'header_text' => null, 'header_text_color' => null, 'header_background_color' => null, 'footer_image' => null, 'footer_text' => null, 'footer_text_color' => null, 'footer_background_color' => null, 'footer_bottom_image' => null, 'key' => 'verification_email', 'name' => 'Verify Your Email', 'subject' => 'Verify Your Email', 'body' => 'Hello {name},

                    Please verify your email by clicking the link below

                    <a href="{url}">{url}</a>

                    Regards,
                    {app_name}', 'placeholders' => '["name", "app_name", "url"]', 'header' => '0', 'footer' => '0', 'deleted_at' => null, 'created_at' => '2025-06-04 18:09:41', 'updated_at' => '2025-06-04 20:28:48'],
            ['id' => '3', 'header_image' => null, 'header_text' => null, 'header_text_color' => null, 'header_background_color' => null, 'footer_image' => null, 'footer_text' => null, 'footer_text_color' => null, 'footer_background_color' => null, 'footer_bottom_image' => null, 'key' => 'forget_password', 'name' => 'Forget Password', 'subject' => 'Forget Password', 'body' => 'Dear {name},

                    You requested to change your password please click the link below to reset your password.

                    <a href="{url}">Change Password</a>

                    Regards,
                    {app_name}', 'placeholders' => '["name", "app_name", "url"]', 'header' => '0', 'footer' => '0', 'deleted_at' => null, 'created_at' => '2025-06-04 20:34:50', 'updated_at' => '2025-06-04 20:34:50'],
            ['id' => '4', 'header_image' => null, 'header_text' => null, 'header_text_color' => null, 'header_background_color' => null, 'footer_image' => null, 'footer_text' => null, 'footer_text_color' => null, 'footer_background_color' => null, 'footer_bottom_image' => null, 'key' => 'verification_code', 'name' => 'Send Verification Code', 'subject' => 'Verification Code', 'body' => 'Dear {name}

          Please enter your verification code as below.

          {code}

          Regards,
          {app_name}', 'placeholders' => '["name", "code", "app_name"]', 'header' => '0', 'footer' => '0', 'deleted_at' => null, 'created_at' => '2025-06-04 21:56:02', 'updated_at' => '2025-06-04 21:56:02'],
        ];

        DB::table('email_templates')->insert($email_templates);
    }
}
