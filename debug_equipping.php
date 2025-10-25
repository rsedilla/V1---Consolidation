<?php
/**
 * Debug Equipping User Assignment
 * Run this via: php debug_equipping.php <email>
 * Example: php debug_equipping.php mon@gmail.com
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

if ($argc < 2) {
    echo "Usage: php debug_equipping.php <email>\n";
    echo "Example: php debug_equipping.php mon@gmail.com\n";
    exit(1);
}

$email = $argv[1];

$user = \App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "User not found: $email\n";
    exit(1);
}

echo "\n=== Equipping User Debug for: $email ===\n\n";
echo "User ID: {$user->id}\n";
echo "Name: {$user->name}\n";
echo "Role: {$user->role}\n";
echo "G12 Leader ID (assigned): " . ($user->g12_leader_id ?? 'NULL') . "\n";

echo "\n--- Assigned Leader Info ---\n";
if ($user->assignedLeader) {
    echo "Assigned Leader: {$user->assignedLeader->name}\n";
    echo "Assigned Leader ID: {$user->assignedLeader->id}\n";
    
    $descendants = $user->assignedLeader->getAllDescendantIds();
    echo "Number of descendants: " . count($descendants) . "\n";
    echo "Descendant IDs: " . implode(', ', $descendants) . "\n";
} else {
    echo "NO ASSIGNED LEADER!\n";
    echo "This means the equipping user has g12_leader_id = NULL\n";
}

echo "\n--- Leader Record Info ---\n";
if ($user->leaderRecord) {
    echo "User IS a G12 Leader: {$user->leaderRecord->name}\n";
    echo "Leader Record ID: {$user->leaderRecord->id}\n";
    
    $descendants = $user->leaderRecord->getAllDescendantIds();
    echo "Number of descendants: " . count($descendants) . "\n";
    echo "Descendant IDs: " . implode(', ', $descendants) . "\n";
} else {
    echo "User is NOT a G12 Leader\n";
}

echo "\n--- Filtering Logic ---\n";
$visibleLeaderIds = $user->getVisibleLeaderIdsForFiltering();
if (empty($visibleLeaderIds)) {
    echo "⚠️  Empty array = SEE ALL DATA (no filtering)\n";
} else {
    echo "Filtered to " . count($visibleLeaderIds) . " leaders: " . implode(', ', $visibleLeaderIds) . "\n";
}

echo "\n=== End Debug ===\n\n";
