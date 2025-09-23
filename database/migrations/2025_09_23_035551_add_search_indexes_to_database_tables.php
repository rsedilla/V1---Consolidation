<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add essential search indexes for better performance
        // Only create indexes that don't already exist

        // Members table indexes
        if (!$this->indexExists('members', 'idx_members_search_name')) {
            DB::statement('CREATE INDEX idx_members_search_name ON members (first_name, last_name)');
        }
        
        if (!$this->indexExists('members', 'idx_members_email')) {
            DB::statement('CREATE INDEX idx_members_email ON members (email)');
        }
        
        if (!$this->indexExists('members', 'idx_members_phone')) {
            DB::statement('CREATE INDEX idx_members_phone ON members (phone)');
        }
        
        // Users table indexes
        if (!$this->indexExists('users', 'idx_users_name')) {
            DB::statement('CREATE INDEX idx_users_name ON users (name)');
        }
        
        if (!$this->indexExists('users', 'idx_users_role')) {
            DB::statement('CREATE INDEX idx_users_role ON users (role)');
        }
        
        // G12 Leaders table indexes
        if (!$this->indexExists('g12_leaders', 'idx_g12_leaders_name')) {
            DB::statement('CREATE INDEX idx_g12_leaders_name ON g12_leaders (name)');
        }
        
        // Member types table index
        if (!$this->indexExists('member_types', 'idx_member_types_name')) {
            DB::statement('CREATE INDEX idx_member_types_name ON member_types (name)');
        }
        
        // Statuses table index
        if (!$this->indexExists('statuses', 'idx_statuses_name')) {
            DB::statement('CREATE INDEX idx_statuses_name ON statuses (name)');
        }
        
        // VIP Statuses table index
        if (!$this->indexExists('vip_statuses', 'idx_vip_statuses_name')) {
            DB::statement('CREATE INDEX idx_vip_statuses_name ON vip_statuses (name)');
        }
    }

    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $indexName): bool
    {
        // Validate table name to prevent SQL injection
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $table)) {
            throw new InvalidArgumentException('Invalid table name');
        }
        
        // Use parameterized query for index name, table name is validated above
        $indexes = DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
        return !empty($indexes);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the indexes we created
        DB::statement('DROP INDEX IF EXISTS idx_members_search_name ON members');
        DB::statement('DROP INDEX IF EXISTS idx_members_email ON members');
        DB::statement('DROP INDEX IF EXISTS idx_members_phone ON members');
        DB::statement('DROP INDEX IF EXISTS idx_users_name ON users');
        DB::statement('DROP INDEX IF EXISTS idx_users_role ON users');
        DB::statement('DROP INDEX IF EXISTS idx_g12_leaders_name ON g12_leaders');
        DB::statement('DROP INDEX IF EXISTS idx_member_types_name ON member_types');
        DB::statement('DROP INDEX IF EXISTS idx_statuses_name ON statuses');
        DB::statement('DROP INDEX IF EXISTS idx_vip_statuses_name ON vip_statuses');
    }
};
