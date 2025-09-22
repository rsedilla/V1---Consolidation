<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\G12Leader;

echo "=== CURRENT G12 LEADERS ===" . PHP_EOL;
$leaders = G12Leader::all(['id', 'name', 'parent_id']);
foreach ($leaders as $leader) {
    echo "ID: {$leader->id} | Name: {$leader->name} | Parent: " . ($leader->parent_id ?? 'NULL') . PHP_EOL;
}

echo PHP_EOL . "=== SETTING UP HIERARCHY ===" . PHP_EOL;

// Find Raymond Sedilla
$raymond = G12Leader::where('name', 'LIKE', '%Raymond%Sedilla%')->first();
if (!$raymond) {
    echo "ERROR: Raymond Sedilla not found!" . PHP_EOL;
    exit(1);
}

echo "Found Raymond Sedilla (ID: {$raymond->id})" . PHP_EOL;

// Set all other leaders as children of Raymond (except Raymond himself)
$otherLeaders = G12Leader::where('id', '!=', $raymond->id)->get();
$updated = 0;

foreach ($otherLeaders as $leader) {
    if ($leader->parent_id !== $raymond->id) {
        $leader->parent_id = $raymond->id;
        $leader->save();
        echo "Set {$leader->name} (ID: {$leader->id}) as child of Raymond" . PHP_EOL;
        $updated++;
    }
}

echo PHP_EOL . "=== HIERARCHY SETUP COMPLETE ===" . PHP_EOL;
echo "Updated {$updated} leaders to be under Raymond Sedilla" . PHP_EOL;
echo "Raymond Sedilla is now the top-level leader with " . count($otherLeaders) . " direct reports" . PHP_EOL;

echo PHP_EOL . "=== FINAL HIERARCHY STRUCTURE ===" . PHP_EOL;
$leaders = G12Leader::all(['id', 'name', 'parent_id']);
foreach ($leaders as $leader) {
    if ($leader->parent_id === null) {
        echo "🔝 {$leader->name} (ID: {$leader->id}) - TOP LEVEL" . PHP_EOL;
    } else {
        echo "   └── {$leader->name} (ID: {$leader->id}) -> Parent: {$leader->parent_id}" . PHP_EOL;
    }
}