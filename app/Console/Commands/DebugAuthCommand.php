<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\G12Leader;
use App\Models\Member;

class DebugAuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:auth {email=alex@gmail.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug authentication and data relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("=== Checking User: {$email} ===");
        $user = User::where('email', $email)->first();
        
        if ($user) {
            $this->line("User found:");
            $this->line("- ID: {$user->id}");
            $this->line("- Name: {$user->name}");
            $this->line("- Email: {$user->email}");
            $this->line("- Role: {$user->role}");
            $this->line("- G12 Leader ID: {$user->g12_leader_id}");
            $this->line("- Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No'));
            $this->line("- Is Leader: " . ($user->isLeader() ? 'Yes' : 'No'));
            $this->line("- Can Access Leader Data: " . ($user->canAccessLeaderData() ? 'Yes' : 'No'));
        } else {
            $this->error("User NOT found!");
        }

        $this->info("\n=== Checking G12 Leaders ===");
        $g12Leaders = G12Leader::all();
        foreach ($g12Leaders as $leader) {
            $this->line("G12 Leader ID: {$leader->id}, Name: {$leader->name}, User ID: {$leader->user_id}");
        }

        $this->info("\n=== Checking VIP Members ===");
        $vipMembers = Member::whereHas('memberType', function ($q) {
            $q->where('name', 'VIP');
        })->get();

        foreach ($vipMembers as $member) {
            $this->line("VIP Member ID: {$member->id}, Name: {$member->first_name} {$member->last_name}, G12 Leader ID: {$member->g12_leader_id}");
        }

        if ($user && $user->canAccessLeaderData()) {
            $this->info("\n=== Filtered VIP Members for User's G12 Leader ===");
            $filteredMembers = Member::whereHas('memberType', function ($q) {
                $q->where('name', 'VIP');
            })->where('g12_leader_id', $user->getG12LeaderId())->get();
            
            foreach ($filteredMembers as $member) {
                $this->line("Filtered VIP Member ID: {$member->id}, Name: {$member->first_name} {$member->last_name}");
            }
        } elseif ($user && $user->isAdmin()) {
            $this->info("\n=== Admin can see all VIP Members ===");
        }
        
        return 0;
    }
}
