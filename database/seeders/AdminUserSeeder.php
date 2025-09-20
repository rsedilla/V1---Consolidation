<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create default admin user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@church.com'],
            [
                'name' => 'Church Administrator',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Update first user to admin if no admin exists
        if (!User::where('role', 'admin')->exists()) {
            $firstUser = User::first();
            if ($firstUser) {
                $firstUser->update(['role' => 'admin']);
                $this->command->info("Updated user '{$firstUser->name}' to admin role.");
            }
        }

        $this->command->info('Admin user seeder completed.');
    }
}
