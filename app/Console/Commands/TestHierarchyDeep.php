<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\G12Leader;

class TestHierarchyDeep extends Command
{
    protected $signature = 'test:hierarchy-deep';
    protected $description = 'Test hierarchy method with deep nesting';

    public function handle()
    {
        $this->info("Testing Deep Hierarchy Method");
        
        // Create a test hierarchy: Manuel -> Alexis -> TestLeader
        $manuel = G12Leader::find(82);
        $alexis = G12Leader::find(86);
        
        // Create a new leader under Alexis
        $testLeader = G12Leader::create([
            'name' => 'Test Sub Leader',
            'parent_id' => 86,
            'user_id' => null
        ]);
        
        $this->info("Created test leader: {$testLeader->name} (ID: {$testLeader->id}) under Alexis");
        
        // Fresh load of Manuel with relationships
        $manuel = G12Leader::with(['children', 'children.children'])->find(82);
        
        $this->info("Manuel's direct children:");
        foreach ($manuel->children as $child) {
            $this->info("  - {$child->name} (ID: {$child->id})");
            foreach ($child->children as $grandchild) {
                $this->info("    - {$grandchild->name} (ID: {$grandchild->id})");
            }
        }
        
        // Test getAllDescendantIds manually
        $this->info("\nTesting getAllDescendantIds:");
        $descendants = $manuel->getAllDescendantIds();
        $this->info("Result: " . implode(', ', $descendants));
        
        // Check if our test leader is included
        if (in_array($testLeader->id, $descendants)) {
            $this->info("✅ Test leader IS included in descendants");
        } else {
            $this->error("❌ Test leader NOT included in descendants");
        }
        
        // Clean up
        $testLeader->delete();
        $this->info("Cleaned up test leader");
    }
}