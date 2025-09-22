<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Checking for duplicate entries before removing soft deletes...\n\n";

// Find all duplicates
$duplicates = DB::select("
    SELECT first_name, last_name, COUNT(*) as count, 
           GROUP_CONCAT(id ORDER BY created_at) as ids
    FROM members 
    GROUP BY first_name, last_name 
    HAVING COUNT(*) > 1
");

if (empty($duplicates)) {
    echo "No duplicates found.\n";
} else {
    echo "Found duplicates:\n";
    foreach ($duplicates as $dup) {
        echo "Name: {$dup->first_name} {$dup->last_name}\n";
        echo "Count: {$dup->count}\n";
        echo "IDs: {$dup->ids}\n";
        
        $ids = explode(',', $dup->ids);
        
        // Keep the first record (usually oldest), delete the rest
        $keepId = $ids[0];
        $deleteIds = array_slice($ids, 1);
        
        echo "Keeping ID: {$keepId}\n";
        echo "Deleting IDs: " . implode(', ', $deleteIds) . "\n";
        
        // Force delete the duplicates
        DB::table('members')->whereIn('id', $deleteIds)->delete();
        
        echo "✓ Cleaned up\n";
        echo "---\n";
    }
}

echo "\nDuplicate cleanup completed.\n";