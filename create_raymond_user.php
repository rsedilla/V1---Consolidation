<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\G12Leader;
use App\Models\User;

echo "=== CREATING USER ACCOUNT FOR RAYMOND SEDILLA ===" . PHP_EOL;

$raymond = G12Leader::where('name', 'LIKE', '%Raymond%Sedilla%')->first();

// Check if Raymond already has a user account
$existingUser = User::where('g12_leader_id', $raymond->id)->first();
if ($existingUser) {
    echo "Raymond already has a user account: {$existingUser->email}" . PHP_EOL;
    exit(0);
}

// Create user account for Raymond
$raymondUser = User::create([
    'name' => 'Raymond Sedilla',
    'email' => 'raymond.sedilla@example.com',
    'password' => bcrypt('password123'),
    'role' => 'leader',
    'g12_leader_id' => $raymond->id,
]);

echo "Created user account for Raymond Sedilla:" . PHP_EOL;
echo "- Email: {$raymondUser->email}" . PHP_EOL;
echo "- Role: {$raymondUser->role}" . PHP_EOL;
echo "- G12 Leader ID: {$raymondUser->g12_leader_id}" . PHP_EOL;

// Update the G12Leader record to link back to the user
$raymond->user_id = $raymondUser->id;
$raymond->save();

echo "- Linked G12Leader record to user (user_id: {$raymondUser->id})" . PHP_EOL;

echo PHP_EOL . "=== TESTING RAYMOND'S PERMISSIONS ===" . PHP_EOL;

echo "Raymond's User Account:" . PHP_EOL;
echo "- Role: {$raymondUser->role}" . PHP_EOL;
echo "- Can Access Leader Data: " . ($raymondUser->canAccessLeaderData() ? 'Yes' : 'No') . PHP_EOL;
echo "- Available G12 Leaders Count: " . count($raymondUser->getAvailableG12Leaders()) . PHP_EOL;
echo "- Available Consolidators Count: " . count($raymondUser->getAvailableConsolidators()) . PHP_EOL;

// Test member visibility for Raymond (should see ALL members via hierarchy)
$visibleMembersQuery = $raymondUser->getVisibleMembers();
$visibleMembersCount = $visibleMembersQuery->count();
echo "- Visible Members Count: {$visibleMembersCount}" . PHP_EOL;

$raymondVisibleLeaderIds = $raymond->getAllDescendantIds();
echo "- Can see members from " . count($raymondVisibleLeaderIds) . " G12 leaders" . PHP_EOL;
echo "- Visible G12 Leader IDs: [" . implode(', ', $raymondVisibleLeaderIds) . "]" . PHP_EOL;

echo PHP_EOL . "✅ Raymond Sedilla can now log in and see all members in the hierarchy!" . PHP_EOL;