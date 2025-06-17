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
            ['id' => '1', 'header_image' => null, 'header_text' => null, 'header_text_color' => null, 'header_background_color' => null, 'footer_image' => null, 'footer_text' => null, 'footer_text_color' => null, 'footer_background_color' => null, 'footer_bottom_image' => null, 'key' => 'code_verification', 'name' => 'Code Verification Email', 'subject' => 'Verify Your Account {app_name}', 'body' => 'Dear {name},

              Thank you for registering with {app_name}.

              To complete your account verification, please enter the 6-digit verification code below:

              Your Verification Code:
              {verification_code}

              If you did not request this verification, please ignore this email or contact our support team immediately.

              If you have any questions or need assistance, feel free to reach out.

              Best regards,
              The {app_name} Team
              {app_url}', 'placeholders' => '["name", "app_name", "verification_code", "app_url"]', 'header' => '0', 'footer' => '0', 'deleted_at' => null, 'created_at' => '2025-06-17 14:48:36', 'updated_at' => '2025-06-17 14:53:59'],
            ['id' => '2', 'header_image' => null, 'header_text' => null, 'header_text_color' => null, 'header_background_color' => null, 'footer_image' => null, 'footer_text' => null, 'footer_text_color' => null, 'footer_background_color' => null, 'footer_bottom_image' => null, 'key' => 'welcome_email', 'name' => 'Welcome Email', 'subject' => 'Welcome to {app_name} – You’re All Set!', 'body' => 'Dear {name},

              Welcome to {app_name} – we’re excited to have you on board!

              Your account has been successfully verified, and you\'re now ready to explore everything we have to offer. we\'re here to support you every step of the way.

              Thank you for choosing {app_name}. We look forward to helping you succeed!

              Warm regards,
              The {app_name} Team
              {app_url}', 'placeholders' => '["name", "app_name", "app_url"]', 'header' => '0', 'footer' => '0', 'deleted_at' => null, 'created_at' => '2025-06-17 14:56:20', 'updated_at' => '2025-06-17 14:56:20'],
            ['id' => '3', 'header_image' => null, 'header_text' => null, 'header_text_color' => null, 'header_background_color' => null, 'footer_image' => null, 'footer_text' => null, 'footer_text_color' => null, 'footer_background_color' => null, 'footer_bottom_image' => null, 'key' => 'reset_password', 'name' => 'Reset Your Password', 'subject' => 'Reset Your Password – {app_name}', 'body' => 'Dear {name},

              We received a request to reset the password for your {app_name} account.

              To reset your password, please click the link below:

              Reset Password:
              {reset_url}

              This link will expire in 30 minutes for your security.

              If you did not request this change, please ignore this email or contact our support team immediately.

              We\'re here if you need any help.

              Best regards,
              The {app_name} Team
              {app_url}', 'placeholders' => '["name", "app_name", "app_url", "reset_url"]', 'header' => '0', 'footer' => '0', 'deleted_at' => null, 'created_at' => '2025-06-17 14:59:46', 'updated_at' => '2025-06-17 14:59:46'],
        ];

        DB::table('email_templates')->insert($email_templates);
    }
}
