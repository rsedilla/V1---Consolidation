<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add performance indexes to g12_leaders table for hierarchy traversal optimization.
     * These indexes dramatically improve parent-child relationship queries.
     */
    public function up(): void
    {
        Schema::table('g12_leaders', function (Blueprint $table) {
            // Index for parent_id lookups (hierarchy traversal)
            // Optimizes: G12Leader::where('parent_id', $id)->get()
            if (!$this->indexExists('g12_leaders', 'idx_g12_parent_id')) {
                $table->index('parent_id', 'idx_g12_parent_id');
            }
            
            // Composite index for parent + user lookups
            // Optimizes: Finding leaders by parent and checking user assignments
            if (!$this->indexExists('g12_leaders', 'idx_g12_parent_user')) {
                $table->index(['parent_id', 'user_id'], 'idx_g12_parent_user');
            }
            
            // Index for user_id lookups (finding leader record for a user)
            // Optimizes: User->leaderRecord relationship queries
            if (!$this->indexExists('g12_leaders', 'idx_g12_user_id')) {
                $table->index('user_id', 'idx_g12_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('g12_leaders', function (Blueprint $table) {
            // Drop indexes in reverse order
            if ($this->indexExists('g12_leaders', 'idx_g12_user_id')) {
                $table->dropIndex('idx_g12_user_id');
            }
            
            if ($this->indexExists('g12_leaders', 'idx_g12_parent_user')) {
                $table->dropIndex('idx_g12_parent_user');
            }
            
            if ($this->indexExists('g12_leaders', 'idx_g12_parent_id')) {
                $table->dropIndex('idx_g12_parent_id');
            }
        });
    }
    
    /**
     * Check if an index exists on a table.
     */
    private function indexExists(string $table, string $index): bool
    {
        $connection = Schema::getConnection();
        $database = $connection->getDatabaseName();
        
        $result = $connection->select(
            "SELECT COUNT(*) as count 
             FROM information_schema.statistics 
             WHERE table_schema = ? 
             AND table_name = ? 
             AND index_name = ?",
            [$database, $table, $index]
        );
        
        return $result[0]->count > 0;
    }
};
