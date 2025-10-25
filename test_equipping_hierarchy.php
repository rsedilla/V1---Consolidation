<?php
/**
 * Test Equipping User Hierarchy Filtering
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$mon = \App\Models\User::where('email', 'mon@gmail.com')->first();
$ranee = \App\Models\User::where('email', 'ranee@gmail.com')->first();

echo "\n=== Testing Hierarchy Filtering ===\n\n";

// Test mon as leader
echo "mon@gmail.com as LEADER:\n";
echo "  Leader Record ID: {$mon->leaderRecord->id}\n";
$monLeaderIds = $mon->getVisibleLeaderIdsForFiltering();
echo "  Visible Leaders: " . count($monLeaderIds) . " (" . implode(', ', $monLeaderIds) . ")\n";

// Test ranee as leader
echo "\nranee@gmail.com as LEADER:\n";
echo "  Leader Record ID: {$ranee->leaderRecord->id}\n";
$raneeLeaderIds = $ranee->getVisibleLeaderIdsForFiltering();
echo "  Visible Leaders: " . count($raneeLeaderIds) . " (" . implode(', ', $raneeLeaderIds) . ")\n";

// Simulate mon as equipping
echo "\n--- Simulating mon as EQUIPPING ---\n";
$mon->role = 'equipping';
$monEquippingIds = $mon->getVisibleLeaderIdsForFiltering();
echo "mon@gmail.com as EQUIPPING:\n";
echo "  Visible Leaders: " . count($monEquippingIds) . " (" . implode(', ', $monEquippingIds) . ")\n";

// Check if mon can see ranee's leaders
$raneeOnlyIds = array_diff($raneeLeaderIds, $monLeaderIds);
echo "\nranee's exclusive leaders: " . count($raneeOnlyIds) . " (" . implode(', ', $raneeOnlyIds) . ")\n";

$canSeeRaneeLeaders = !empty(array_intersect($raneeOnlyIds, $monEquippingIds));
echo "\n✓ Can mon (equipping) see ranee's exclusive leaders? " . ($canSeeRaneeLeaders ? 'YES ✗ (BUG!)' : 'NO ✓ (CORRECT!)') . "\n";

echo "\n=== Test Complete ===\n\n";
