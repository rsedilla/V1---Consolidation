<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Member;

class TestHierarchyFiltering extends Command
{
    protected $signature = 'test:hierarchy-filtering {--id=} {--email=}';
    protected $description = 'Test hierarchy filtering for VIP members';

    public function handle()
    {
        $id = $this->option('id');
        $email = $this->option('email');
        
        if ($id) {
            $user = User::find($id);
        } elseif ($email) {
            $user = User::where('email', $email)->first();
        } else {
            $this->error("Please provide either --id or --email option.");
            return;
        }
        
        if (!$user) {
            $this->error("User not found.");
            return;
        }

        $this->info("Testing hierarchy filtering for user: {$user->name} ({$user->email})");
        $this->info("User role: {$user->role}");
        $this->info("G12 Leader ID: {$user->g12_leader_id}");
        
        if ($user->leaderRecord) {
            $this->info("Leader Record ID: {$user->leaderRecord->id}");
            $this->info("Parent ID: {$user->leaderRecord->parent_id}");
            
            $descendantIds = $user->leaderRecord->getAllDescendantIds();
            $this->info("Visible G12 Leader IDs: " . implode(', ', $descendantIds));
            
            // Test VIP member filtering
            $vipMembers = Member::where('member_type', 'VIP')->whereIn('g12_leader_id', $descendantIds)->get();
            $this->info("VIP Members accessible to this user:");
            
            foreach ($vipMembers as $vipMember) {
                $this->info("- {$vipMember->first_name} {$vipMember->last_name} (G12 Leader ID: {$vipMember->g12_leader_id})");
            }
            
            if ($vipMembers->count() === 0) {
                $this->warn("No VIP members found for this hierarchy.");
            }
        } else {
            $this->warn("User does not have a leader record.");
        }
    }
}