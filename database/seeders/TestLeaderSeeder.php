<?php

namespace Database\Seeders;

use App\Models\G12Leader;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestLeaderSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Find "Bon Ryan Fran" in G12 leaders table
        $g12Leader = G12Leader::where('name', 'Bon Ryan Fran')->first();
        
        if ($g12Leader) {
            // Create or update Bon Ryan Fran user account
            User::updateOrCreate(
                ['email' => 'bonryan@gmail.com'],
                [
                    'name' => 'Bon Ryan Fran',
                    'role' => 'leader',
                    'g12_leader_id' => $g12Leader->id,
                    'password' => Hash::make('leader123'),
                    'email_verified_at' => now(),
                ]
            );
            
            $this->command->info("Created/Updated leader user: bonryan@gmail.com (password: leader123)");
            $this->command->info("Assigned to G12 Leader: {$g12Leader->name} (ID: {$g12Leader->id})");
        } else {
            $this->command->error("G12 Leader 'Bon Ryan Fran' not found. Please run G12LeaderSeeder first.");
        }
    }
}
