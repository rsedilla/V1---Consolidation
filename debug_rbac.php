<?php
/**
 * Debug RBAC on Hostinger
 * Run this via: php debug_rbac.php <email>
 * Example: php debug_rbac.php jade@gmail.com
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

if ($argc < 2) {
    echo "Usage: php debug_rbac.php <email>\n";
    echo "Example: php debug_rbac.php jade@gmail.com\n";
    exit(1);
}

$email = $argv[1];

$user = \App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "User not found: $email\n";
    exit(1);
}

echo "\n=== RBAC Debug for: $email ===\n\n";
echo "User ID: {$user->id}\n";
echo "Name: {$user->name}\n";
echo "Role (raw): '{$user->role}'\n";
echo "Role (trimmed): '" . trim($user->role) . "'\n";
echo "\n--- Role Checks ---\n";
echo "isAdmin(): " . ($user->isAdmin() ? 'TRUE' : 'FALSE') . "\n";
echo "isLeader(): " . ($user->isLeader() ? 'TRUE' : 'FALSE') . "\n";
echo "isEquipping(): " . ($user->isEquipping() ? 'TRUE' : 'FALSE') . "\n";
echo "hasLeadershipRole(): " . ($user->hasLeadershipRole() ? 'TRUE' : 'FALSE') . "\n";
echo "\n--- Button Logic ---\n";
echo "Should see Edit/Delete buttons: " . (($user->isAdmin() || $user->isEquipping()) ? 'YES' : 'NO') . "\n";
echo "Buttons should be disabled: " . (!($user->isAdmin() || $user->isEquipping()) ? 'YES' : 'NO') . "\n";
echo "\n=== End Debug ===\n\n";
