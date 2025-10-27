<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Only delete and seed if no users exist (fresh install)
        if (DB::table('users')->count() > 0) {
            $this->command->info('Users already exist. Skipping seeding.');
            return;
        }
        
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'rsedilla@gmail.com',
                'password' => Hash::make('monmon'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manuel domingo',
                'email' => 'manuel_domingojr@dlsu.edu.ph',
                'password' => Hash::make('manuel'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
