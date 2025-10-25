<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\G12Leader;
use App\Models\Member;

echo "=== Dashboard Debug Script ===\n\n";

// Get the logged-in user (change email if needed)
$userEmail = 'ronsedilla@yahoo.com'; // Change this to your Hostinger user email
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
echo "isLeader(): " . ($user->isLeader() ? 'YES' : 'NO') . "\n";
echo "isEquipping(): " . (method_exists($user, 'isEquipping') ? ($user->isEquipping() ? 'YES' : 'NO') : 'N/A') . "\n";
echo "hasLeadershipRole(): " . (method_exists($user, 'hasLeadershipRole') ? ($user->hasLeadershipRole() ? 'YES' : 'NO') : 'N/A') . "\n\n";

// Check leader record
echo "=== Leader Record ===\n";
if ($user->leaderRecord) {
    echo "Leader Record ID: {$user->leaderRecord->id}\n";
    echo "Leader Name: {$user->leaderRecord->user->name}\n";
    echo "Parent ID: " . ($user->leaderRecord->parent_id ?? 'NULL (Root)') . "\n";
    
    if ($user->leaderRecord->parent) {
        echo "Parent Name: {$user->leaderRecord->parent->user->name}\n";
    }
    
    $descendants = $user->leaderRecord->getAllDescendantIds();
    echo "Total Descendants: " . count($descendants) . "\n";
    echo "Descendant IDs: " . implode(', ', $descendants) . "\n\n";
} else {
    echo "No leader record found\n\n";
}

// Check what the dashboard would show
echo "=== Dashboard Logic ===\n";

if ($user->isAdmin()) {
    echo "Dashboard shows: Admin view (top-level leaders)\n";
    
    $rootLeader = G12Leader::whereNull('parent_id')->first();
    if ($rootLeader) {
        $topLevelLeaders = G12Leader::with('user')
            ->where('parent_id', $rootLeader->id)
            ->whereHas('user')
            ->get();
        echo "Number of cards to show: " . $topLevelLeaders->count() . "\n";
        foreach ($topLevelLeaders as $leader) {
            echo "  - {$leader->user->name}\n";
        }
    }
} elseif ($user->isLeader() && $user->leaderRecord) {
    echo "Dashboard shows: Leader view (direct children + summary stats)\n";
    
    $directChildren = G12Leader::with('user')
        ->where('parent_id', $user->leaderRecord->id)
        ->whereHas('user')
        ->get();
    
    echo "Number of leader cards to show: " . $directChildren->count() . "\n";
    foreach ($directChildren as $leader) {
        $descendantIds = $leader->getAllDescendantIds();
        $vipCount = Member::vips()->underLeaders($descendantIds)->count();
        echo "  - {$leader->user->name}: {$vipCount} VIPs\n";
    }
    
    // Check summary stats
    $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
    $totalVips = Member::vips()->underLeaders($visibleLeaderIds)->count();
    echo "\nSummary Stats:\n";
    echo "  - My Total VIPs: {$totalVips}\n";
} else {
    echo "Dashboard shows: NOTHING (user doesn't match admin or leader conditions)\n";
    echo "This is why the dashboard is empty!\n";
}
