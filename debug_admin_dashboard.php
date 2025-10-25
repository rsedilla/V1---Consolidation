<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\G12Leader;
use App\Models\Member;

echo "=== Admin Dashboard Debug Script ===\n\n";

// Get the admin user
$userEmail = 'rsedilla@gmail.com';
$user = User::where('email', $userEmail)->first();

if (!$user) {
    echo "User not found with email: $userEmail\n";
    exit;
}

echo "User: {$user->name} ({$user->email})\n";
echo "User ID: {$user->id}\n";
echo "Role ID: {$user->role_id}\n\n";

// Check role methods
echo "=== Role Checks ===\n";
echo "isAdmin(): " . ($user->isAdmin() ? 'YES' : 'NO') . "\n";
echo "isLeader(): " . ($user->isLeader() ? 'YES' : 'NO') . "\n\n";

// Check G12 hierarchy
echo "=== G12 Leader Hierarchy ===\n";
$rootLeader = G12Leader::whereNull('parent_id')->first();

if ($rootLeader) {
    echo "Root Leader Found:\n";
    echo "  ID: {$rootLeader->id}\n";
    echo "  User: " . ($rootLeader->user ? $rootLeader->user->name : 'No user linked') . "\n\n";
    
    // Get direct children of root (these should appear as cards for admin)
    $topLevelLeaders = G12Leader::with('user')
        ->where('parent_id', $rootLeader->id)
        ->whereHas('user')
        ->get();
    
    echo "Top-Level Leaders (Direct children of root - should appear as cards):\n";
    echo "Total: {$topLevelLeaders->count()}\n\n";
    
    if ($topLevelLeaders->count() > 0) {
        foreach ($topLevelLeaders as $leader) {
            $descendantIds = $leader->getAllDescendantIds();
            $vipCount = Member::vips()->underLeaders($descendantIds)->count();
            echo "  - {$leader->user->name} (ID: {$leader->id})\n";
            echo "    VIP count: {$vipCount}\n";
            echo "    Descendants: " . count($descendantIds) . "\n\n";
        }
    } else {
        echo "  NO TOP-LEVEL LEADERS FOUND!\n";
        echo "  This is why the admin dashboard shows no leader cards.\n\n";
    }
} else {
    echo "NO ROOT LEADER FOUND!\n";
    echo "Checking for leaders without parent (fallback):\n\n";
    
    $orphanLeaders = G12Leader::with('user')
        ->whereNull('parent_id')
        ->whereHas('user')
        ->get();
    
    echo "Leaders without parent: {$orphanLeaders->count()}\n";
    foreach ($orphanLeaders as $leader) {
        echo "  - {$leader->user->name} (ID: {$leader->id})\n";
    }
}

// Check summary stats
echo "\n=== Summary Stats ===\n";
$totalVips = Member::vips()->count();
$totalConsolidators = Member::consolidators()->count();
echo "Total VIPs: {$totalVips}\n";
echo "Total Consolidators: {$totalConsolidators}\n";
