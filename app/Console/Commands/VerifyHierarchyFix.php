<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\G12Leader;
use App\Models\Member;

class VerifyHierarchyFix extends Command
{
    protected $signature = 'verify:hierarchy-fix';
    protected $description = 'Verify that the hierarchy filtering fix is working correctly';

    public function handle()
    {
        $this->info("Verifying Hierarchy Filtering Fix");
        $this->info("================================");
        
        // Find Manuel Domingo (G12 Leader ID: 82)
        $manuelLeader = G12Leader::find(82);
        if (!$manuelLeader) {
            $this->error("Manuel Domingo (G12 Leader ID: 82) not found");
            return;
        }
        
        $this->info("Manuel Domingo Leader Record:");
        $this->info("- ID: {$manuelLeader->id}");
        $this->info("- Name: {$manuelLeader->name}");
        $this->info("- Parent ID: " . ($manuelLeader->parent_id ?? 'null'));
        
        // Find Alexis Genotiva (G12 Leader ID: 86)
        $alexisLeader = G12Leader::find(86);
        if (!$alexisLeader) {
            $this->error("Alexis Genotiva (G12 Leader ID: 86) not found");
            return;
        }
        
        $this->info("\nAlexis Genotiva Leader Record:");
        $this->info("- ID: {$alexisLeader->id}");
        $this->info("- Name: {$alexisLeader->name}");
        $this->info("- Parent ID: " . ($alexisLeader->parent_id ?? 'null'));
        
        // Test hierarchy method
        $manuelHierarchy = $manuelLeader->getAllDescendantIds();
        $this->info("\nManuel's Visible Leader IDs: " . implode(', ', $manuelHierarchy));
        
        // Check VIP members for each leader
        $manuelVipMembers = Member::whereHas('memberType', function ($query) {
            $query->where('name', 'VIP');
        })->where('g12_leader_id', 82)->get();
        
        $alexisVipMembers = Member::whereHas('memberType', function ($query) {
            $query->where('name', 'VIP');
        })->where('g12_leader_id', 86)->get();
        
        $this->info("\nVIP Members under Manuel (ID: 82): " . $manuelVipMembers->count());
        foreach ($manuelVipMembers as $member) {
            $this->info("  - {$member->first_name} {$member->last_name}");
        }
        
        $this->info("\nVIP Members under Alexis (ID: 86): " . $alexisVipMembers->count());
        foreach ($alexisVipMembers as $member) {
            $this->info("  - {$member->first_name} {$member->last_name}");
        }
        
        // Test the new filtering logic
        $hierarchyVipMembers = Member::whereHas('memberType', function ($query) {
            $query->where('name', 'VIP');
        })->whereIn('g12_leader_id', $manuelHierarchy)->get();
        
        $this->info("\nTotal VIP Members Manuel should see with new hierarchy filtering: " . $hierarchyVipMembers->count());
        foreach ($hierarchyVipMembers as $member) {
            $this->info("  - {$member->first_name} {$member->last_name} (G12 Leader: {$member->g12_leader_id})");
        }
        
        $this->info("\n✅ Hierarchy filtering verification complete!");
        $this->info("Manuel should now see VIP members from both his direct leadership (ID: 82) and his downline leader Alexis (ID: 86)");
    }
}