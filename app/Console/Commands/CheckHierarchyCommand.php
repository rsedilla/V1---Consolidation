<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\G12Leader;
use App\Models\Member;

class CheckHierarchyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:hierarchy {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check G12 Leader hierarchy and member visibility';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        
        // Find user by name
        $user = User::where('name', 'like', "%{$name}%")->first();
        
        if (!$user) {
            $this->error("User not found: {$name}");
            return 1;
        }
        
        $this->info("=== User: {$user->name} ({$user->email}) ===");
        $this->line("- User ID: {$user->id}");
        $this->line("- Role: {$user->role}");
        $this->line("- Belongs to G12 Leader ID: {$user->g12_leader_id}");
        
        // Check if user has a leader record
        $leaderRecord = $user->leaderRecord;
        if ($leaderRecord) {
            $this->info("\n=== IS G12 Leader: {$leaderRecord->name} (ID: {$leaderRecord->id}) ===");
            $this->line("- Parent Leader ID: {$leaderRecord->parent_id}");
            
            if ($leaderRecord->parent) {
                $this->line("- Parent Leader: {$leaderRecord->parent->name}");
            }
            
            // Check hierarchy
            $descendants = $leaderRecord->getAllDescendantIds();
            $this->info("- Can see G12 Leader IDs: " . implode(', ', $descendants));
            
            // Check members in hierarchy
            $hierarchyMembers = Member::whereIn('g12_leader_id', $descendants)->get();
            $this->info("\n=== Members in Hierarchy ===");
            foreach ($hierarchyMembers as $member) {
                $leader = G12Leader::find($member->g12_leader_id);
                $leaderName = $leader ? $leader->name : 'Unknown';
                $this->line("- {$member->first_name} {$member->last_name} (under {$leaderName})");
            }
            
            // Check VIP members specifically
            $vipMembers = Member::whereIn('g12_leader_id', $descendants)
                ->whereHas('memberType', function ($q) {
                    $q->where('name', 'VIP');
                })->get();
                
            $this->info("\n=== VIP Members in Hierarchy ===");
            foreach ($vipMembers as $member) {
                $leader = G12Leader::find($member->g12_leader_id);
                $leaderName = $leader ? $leader->name : 'Unknown';
                $this->line("- {$member->first_name} {$member->last_name} (under {$leaderName})");
            }
        } else {
            $this->warn("User is not a G12 Leader");
        }
        
        return 0;
    }
}
