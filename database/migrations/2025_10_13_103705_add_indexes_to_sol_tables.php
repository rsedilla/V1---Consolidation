<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = '{$indexName}'");
        return count($indexes) > 0;
    }

    /**
     * Run the migrations.
     * Add performance indexes to SOL-related tables
     */
    public function up(): void
    {
        // Add indexes to sol_profiles table
        if (!$this->indexExists('sol_profiles', 'idx_sol_profiles_member_id')) {
            Schema::table('sol_profiles', function (Blueprint $table) {
                $table->index('member_id', 'idx_sol_profiles_member_id');
            });
        }

        if (!$this->indexExists('sol_profiles', 'idx_sol_profiles_current_level')) {
            Schema::table('sol_profiles', function (Blueprint $table) {
                $table->index('current_sol_level_id', 'idx_sol_profiles_current_level');
            });
        }

        if (!$this->indexExists('sol_profiles', 'idx_sol_profiles_g12_leader')) {
            Schema::table('sol_profiles', function (Blueprint $table) {
                $table->index('g12_leader_id', 'idx_sol_profiles_g12_leader');
            });
        }

        if (!$this->indexExists('sol_profiles', 'idx_sol_profiles_leader_level')) {
            Schema::table('sol_profiles', function (Blueprint $table) {
                $table->index(['g12_leader_id', 'current_sol_level_id'], 'idx_sol_profiles_leader_level');
            });
        }

        // Add indexes to sol_1_candidates table
        if (!$this->indexExists('sol_1_candidates', 'idx_sol1_sol_profile_id')) {
            Schema::table('sol_1_candidates', function (Blueprint $table) {
                $table->index('sol_profile_id', 'idx_sol1_sol_profile_id');
            });
        }

        if (!$this->indexExists('sol_1_candidates', 'idx_sol1_enrollment_date')) {
            Schema::table('sol_1_candidates', function (Blueprint $table) {
                $table->index('enrollment_date', 'idx_sol1_enrollment_date');
            });
        }

        if (!$this->indexExists('sol_1_candidates', 'idx_sol1_graduation_date')) {
            Schema::table('sol_1_candidates', function (Blueprint $table) {
                $table->index('graduation_date', 'idx_sol1_graduation_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from sol_profiles table
        if ($this->indexExists('sol_profiles', 'idx_sol_profiles_member_id')) {
            Schema::table('sol_profiles', function (Blueprint $table) {
                $table->dropIndex('idx_sol_profiles_member_id');
            });
        }

        if ($this->indexExists('sol_profiles', 'idx_sol_profiles_current_level')) {
            Schema::table('sol_profiles', function (Blueprint $table) {
                $table->dropIndex('idx_sol_profiles_current_level');
            });
        }

        if ($this->indexExists('sol_profiles', 'idx_sol_profiles_g12_leader')) {
            Schema::table('sol_profiles', function (Blueprint $table) {
                $table->dropIndex('idx_sol_profiles_g12_leader');
            });
        }

        if ($this->indexExists('sol_profiles', 'idx_sol_profiles_leader_level')) {
            Schema::table('sol_profiles', function (Blueprint $table) {
                $table->dropIndex('idx_sol_profiles_leader_level');
            });
        }

        // Drop indexes from sol_1_candidates table
        if ($this->indexExists('sol_1_candidates', 'idx_sol1_sol_profile_id')) {
            Schema::table('sol_1_candidates', function (Blueprint $table) {
                $table->dropIndex('idx_sol1_sol_profile_id');
            });
        }

        if ($this->indexExists('sol_1_candidates', 'idx_sol1_enrollment_date')) {
            Schema::table('sol_1_candidates', function (Blueprint $table) {
                $table->dropIndex('idx_sol1_enrollment_date');
            });
        }

        if ($this->indexExists('sol_1_candidates', 'idx_sol1_graduation_date')) {
            Schema::table('sol_1_candidates', function (Blueprint $table) {
                $table->dropIndex('idx_sol1_graduation_date');
            });
        }
    }
};
