<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\G12Leader;
use App\Filament\Resources\Members\VipMemberResource;
use Illuminate\Support\Facades\Auth;

class TestNavigationBadge extends Command
{
    protected $signature = 'test:navigation-badge';
    protected $description = 'Test navigation badge count for leaders';

    public function handle()
    {
        $this->info("Testing Navigation Badge Count");
        $this->info("=============================");
        
        // Find Manuel's user account
        $manuelLeader = G12Leader::find(82);
        if (!$manuelLeader || !$manuelLeader->user_id) {
            $this->error("Manuel Domingo user account not found");
            return;
        }
        
        $manuelUser = User::find($manuelLeader->user_id);
        if (!$manuelUser) {
            $this->error("Manuel user not found");
            return;
        }
        
        $this->info("Testing for user: {$manuelUser->name}");
        
        // Simulate authentication
        Auth::login($manuelUser);
        
        // Test the navigation badge
        $badgeCount = VipMemberResource::getNavigationBadge();
        
        $this->info("Navigation badge count: {$badgeCount}");
        
        // Also test the hierarchy manually
        $hierarchyIds = $manuelUser->leaderRecord->getAllDescendantIds();
        $this->info("Manuel's hierarchy IDs: " . implode(', ', $hierarchyIds));
        
        // Count VIP members manually
        $manualCount = \App\Models\Member::whereHas('memberType', function ($query) {
            $query->where('name', 'VIP');
        })->whereIn('g12_leader_id', $hierarchyIds)->count();
        
        $this->info("Manual VIP count in hierarchy: {$manualCount}");
        
        if ($badgeCount == $manualCount) {
            $this->info("✅ Navigation badge count is correct!");
        } else {
            $this->error("❌ Navigation badge count mismatch. Expected: {$manualCount}, Got: {$badgeCount}");
        }
        
        Auth::logout();
    }
}