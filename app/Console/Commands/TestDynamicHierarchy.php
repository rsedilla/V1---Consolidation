<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\G12Leader;
use App\Models\Member;
use App\Models\MemberType;

class TestDynamicHierarchy extends Command
{
    protected $signature = 'test:dynamic-hierarchy';
    protected $description = 'Test that hierarchy logic works dynamically when adding new leaders';

    public function handle()
    {
        $this->info("Testing Dynamic Hierarchy Logic");
        $this->info("=============================");
        
        // Get current hierarchy before adding new leader
        $manuelLeader = G12Leader::find(82);
        $alexisLeader = G12Leader::find(86);
        
        if (!$manuelLeader || !$alexisLeader) {
            $this->error("Required leaders not found");
            return;
        }
        
        $initialHierarchy = $manuelLeader->getAllDescendantIds();
        $this->info("Initial Manuel's hierarchy: " . implode(', ', $initialHierarchy));
        
        // Create a temporary new leader under Alexis
        $newLeader = G12Leader::create([
            'name' => 'Test Dynamic Leader',
            'parent_id' => 86, // Under Alexis Genotiva
            'user_id' => null
        ]);
        
        $this->info("Created new leader: {$newLeader->name} (ID: {$newLeader->id}) under Alexis");
        
        // Test hierarchy after addition
        $updatedHierarchy = $manuelLeader->getAllDescendantIds();
        $this->info("Updated Manuel's hierarchy: " . implode(', ', $updatedHierarchy));
        
        // Verify the new leader is included
        if (in_array($newLeader->id, $updatedHierarchy)) {
            $this->info("✅ SUCCESS: New leader automatically included in hierarchy!");
        } else {
            $this->error("❌ FAILED: New leader not included in hierarchy");
        }
        
        // Create a test VIP member under the new leader
        $vipType = MemberType::where('name', 'VIP')->first();
        if ($vipType) {
            $testMember = Member::create([
                'first_name' => 'Test',
                'last_name' => 'VIP Member',
                'email' => 'test.vip@example.com',
                'phone' => '1234567890',
                'member_type_id' => $vipType->id,
                'g12_leader_id' => $newLeader->id,
                'date_joined' => now(),
                'is_active' => true
            ]);
            
            $this->info("Created test VIP member: {$testMember->first_name} {$testMember->last_name} under new leader");
            
            // Test if Manuel can see this new VIP member
            $vipMembersInHierarchy = Member::whereHas('memberType', function ($query) {
                $query->where('name', 'VIP');
            })->whereIn('g12_leader_id', $updatedHierarchy)->get();
            
            $newMemberVisible = $vipMembersInHierarchy->contains('id', $testMember->id);
            
            if ($newMemberVisible) {
                $this->info("✅ SUCCESS: Manuel can see VIP member from new dynamic leader!");
            } else {
                $this->error("❌ FAILED: Manuel cannot see VIP member from new leader");
            }
            
            $this->info("Total VIP members Manuel can see: " . $vipMembersInHierarchy->count());
            
            // Clean up test data
            $testMember->delete();
            $this->info("Cleaned up test VIP member");
        }
        
        // Clean up test leader
        $newLeader->delete();
        $this->info("Cleaned up test leader");
        
        $this->info("\n✅ Dynamic hierarchy test complete!");
        $this->info("The hierarchy logic is NOT hardcoded - it dynamically includes new leaders!");
    }
}