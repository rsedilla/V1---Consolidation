<?php

// Debug script to check authentication and data
use App\Models\User;
use App\Models\G12Leader;
use App\Models\Member;

// Check the user alex@gmail.com
echo "=== Checking User: alex@gmail.com ===\n";
$user = User::where('email', 'alex@gmail.com')->first();
if ($user) {
    echo "User found:\n";
    echo "- ID: {$user->id}\n";
    echo "- Name: {$user->name}\n";
    echo "- Email: {$user->email}\n";
    echo "- Role: {$user->role}\n";
    echo "- G12 Leader ID: {$user->g12_leader_id}\n";
    echo "- Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No') . "\n";
    echo "- Is Leader: " . ($user->isLeader() ? 'Yes' : 'No') . "\n";
    echo "- Can Access Leader Data: " . ($user->canAccessLeaderData() ? 'Yes' : 'No') . "\n";
} else {
    echo "User NOT found!\n";
}

echo "\n=== Checking G12 Leaders ===\n";
$g12Leaders = G12Leader::all();
foreach ($g12Leaders as $leader) {
    echo "G12 Leader ID: {$leader->id}, Name: {$leader->name}, User ID: {$leader->user_id}\n";
}

echo "\n=== Checking VIP Members ===\n";
$vipMembers = Member::whereHas('memberType', function ($q) {
    $q->where('name', 'VIP');
})->get();

foreach ($vipMembers as $member) {
    echo "VIP Member ID: {$member->id}, Name: {$member->first_name} {$member->last_name}, G12 Leader ID: {$member->g12_leader_id}\n";
}

if ($user && $user->canAccessLeaderData()) {
    echo "\n=== Filtered VIP Members for User's G12 Leader ===\n";
    $filteredMembers = Member::whereHas('memberType', function ($q) {
        $q->where('name', 'VIP');
    })->where('g12_leader_id', $user->getG12LeaderId())->get();
    
    foreach ($filteredMembers as $member) {
        echo "Filtered VIP Member ID: {$member->id}, Name: {$member->first_name} {$member->last_name}\n";
    }
}