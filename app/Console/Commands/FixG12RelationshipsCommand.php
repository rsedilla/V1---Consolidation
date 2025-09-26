<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\G12Leader;

class FixG12RelationshipsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:g12-relationships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix G12 Leader and User relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing G12 Leader and User relationships...');
        
        // Step 1: Fix the relationship for users who ARE G12 leaders
        $this->info('Step 1: Linking G12 Leaders to their User accounts...');
        
        $users = User::whereIn('role', ['leader', 'admin'])->get();
        
        foreach ($users as $user) {
            // Find G12 Leader with matching name
            $g12Leader = G12Leader::where('name', $user->name)->first();
            
            if ($g12Leader) {
                // Set the G12Leader.user_id to point to this user (they ARE this leader)
                $g12Leader->update(['user_id' => $user->id]);
                
                // Set the User.g12_leader_id to point to themselves (they belong to their own leadership)
                $user->update(['g12_leader_id' => $g12Leader->id]);
                
                $this->line("✓ Linked {$user->name} (User ID: {$user->id}) ↔ G12 Leader ID: {$g12Leader->id}");
            } else {
                $this->warn("⚠ No G12 Leader found for user: {$user->name}");
            }
        }
        
        // Step 2: Show current relationships
        $this->info("\nStep 2: Current G12 Leader → User relationships:");
        $g12Leaders = G12Leader::with('user')->get();
        
        foreach ($g12Leaders as $leader) {
            if ($leader->user) {
                $this->line("G12 Leader: {$leader->name} (ID: {$leader->id}) → User: {$leader->user->name} (ID: {$leader->user->id})");
            } else {
                $this->line("G12 Leader: {$leader->name} (ID: {$leader->id}) → No User Account");
            }
        }
        
        // Step 3: Assign VIP members to correct leaders
        $this->info("\nStep 3: Checking VIP member assignments...");
        
        $vipMembers = \App\Models\Member::whereHas('memberType', function ($q) {
            $q->where('name', 'VIP');
        })->get();
        
        foreach ($vipMembers as $member) {
            if (!$member->g12_leader_id) {
                $this->warn("⚠ VIP Member {$member->first_name} {$member->last_name} (ID: {$member->id}) has no G12 Leader assigned");
            } else {
                $leader = G12Leader::find($member->g12_leader_id);
                $leaderName = $leader ? $leader->name : 'Unknown';
                $this->line("✓ VIP Member {$member->first_name} {$member->last_name} → G12 Leader: {$leaderName}");
            }
        }
        
        $this->info("\n✅ G12 relationships fixed!");
        
        return 0;
    }
}
