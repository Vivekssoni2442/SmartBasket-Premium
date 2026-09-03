<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * AdminSeeder
 *
 * Securely provisions initial admin account.
 *
 * Admin credentials MUST be provided via environment variables:
 * - SMARTBASKET_ADMIN_NAME (default: SmartBasket Admin)
 * - SMARTBASKET_ADMIN_EMAIL (required - must be set)
 * - SMARTBASKET_ADMIN_PASSWORD (required - must be set)
 * - SMARTBASKET_ADMIN_PHONE (optional)
 *
 * SECURITY REQUIREMENTS:
 * 1. Never hardcode admin credentials in source code
 * 2. Never commit .env file to version control
 * 3. Only run this seeder during initial setup
 * 4. Credentials must be provided through secure channels (secure deployment, etc.)
 * 5. Change password after first login
 * 6. Enable MFA immediately after initial setup
 *
 * Usage:
 * php artisan db:seed --class=AdminSeeder
 *
 * Or with environment variables:
 * SMARTBASKET_ADMIN_EMAIL=admin@smartbasket.com \
 * SMARTBASKET_ADMIN_PASSWORD=SecurePassword123! \
 * php artisan db:seed --class=AdminSeeder
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Require secure provisioning
        $email = env('SMARTBASKET_ADMIN_EMAIL');
        $password = env('SMARTBASKET_ADMIN_PASSWORD');

        if (!$email || !$password) {
            $this->command->warn(
                'Admin seeding requires SMARTBASKET_ADMIN_EMAIL and SMARTBASKET_ADMIN_PASSWORD environment variables. Skipping.'
            );
            return;
        }

        // Check if admin already exists
        if (Admin::where('email', $email)->exists()) {
            $this->command->warn("Admin with email {$email} already exists. Skipping.");
            return;
        }

        // Create admin account
        $admin = Admin::create([
            'name' => env('SMARTBASKET_ADMIN_NAME', 'SmartBasket Admin'),
            'email' => $email,
            'password' => Hash::make($password),
            'phone' => env('SMARTBASKET_ADMIN_PHONE'),
            'role' => Admin::ROLE_SUPER_ADMIN,
            'status' => Admin::STATUS_ACTIVE,
        ]);

        $this->command->info("Admin account created successfully!");
        $this->command->info("Admin ID: {$admin->id}");
        $this->command->info("Email: {$admin->email}");
        $this->command->warn("⚠️  IMPORTANT SECURITY REMINDERS:");
        $this->command->warn("   1. Change your password immediately after first login");
        $this->command->warn("   2. Enable 2FA (TOTP) for your account");
        $this->command->warn("   3. Store recovery codes in a secure location");
        $this->command->warn("   4. Never share admin credentials");
        $this->command->warn("   5. Review audit logs regularly");
    }
}
