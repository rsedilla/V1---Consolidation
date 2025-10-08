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
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = '{$indexName}'");
            return count($indexes) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Optimized composite index for G12 Leaders hierarchy queries
        // Optimizes: getAllDescendantIds() - parent_id lookups in iterative query
        if (!$this->indexExists('g12_leaders', 'idx_g12_leaders_parent_id')) {
            Schema::table('g12_leaders', function (Blueprint $table) {
                $table->index('parent_id', 'idx_g12_leaders_parent_id');
            });
        }
        
        // Composite index for leaders with users (dashboard query optimization)
        // Optimizes: G12Leader::with('user')->whereHas('user')
        if (!$this->indexExists('g12_leaders', 'idx_g12_leaders_user_parent')) {
            Schema::table('g12_leaders', function (Blueprint $table) {
                $table->index(['user_id', 'parent_id'], 'idx_g12_leaders_user_parent');
            });
        }

        // Optimized composite indexes for Members table (VIP/Consolidator queries)
        // Optimizes: Member::vips()->underLeaders()->active()
        if (!$this->indexExists('members', 'idx_members_leader_type_status')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index(['g12_leader_id', 'member_type_id', 'status_id'], 'idx_members_leader_type_status');
            });
        }

        // Optimized for consolidation date searches
        // Optimizes: VipMembersTable search by consolidation_date
        if (!$this->indexExists('members', 'idx_members_consolidation_date')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index('consolidation_date', 'idx_members_consolidation_date');
            });
        }

        // Composite index for consolidator queries
        // Optimizes: Member::consolidators()->underLeaders()
        if (!$this->indexExists('members', 'idx_members_consolidator_leader')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index(['consolidator_id', 'g12_leader_id'], 'idx_members_consolidator_leader');
            });
        }

        // Optimized for StartUpYourNewLife completion queries
        // Optimizes: StartUpYourNewLife::completed()->whereHas('member')
        if (!$this->indexExists('start_up_your_new_life', 'idx_suynl_member_lessons')) {
            Schema::table('start_up_your_new_life', function (Blueprint $table) {
                $table->index(['member_id', 'lesson_1_completion_date', 'lesson_10_completion_date'], 'idx_suynl_member_lessons');
            });
        }

        // Optimized for SundayService completion queries
        // Optimizes: SundayService::completed()
        if (!$this->indexExists('sunday_services', 'idx_sunday_member_sessions')) {
            Schema::table('sunday_services', function (Blueprint $table) {
                $table->index(['member_id', 'sunday_service_1_date', 'sunday_service_4_date'], 'idx_sunday_member_sessions');
            });
        }

        // Optimized for CellGroup completion queries
        // Optimizes: CellGroup::completed()
        if (!$this->indexExists('cell_groups', 'idx_cell_member_sessions')) {
            Schema::table('cell_groups', function (Blueprint $table) {
                $table->index(['member_id', 'cell_group_1_date', 'cell_group_4_date'], 'idx_cell_member_sessions');
            });
        }

        // Optimized for LifeclassCandidate hierarchy queries
        // Optimizes: LifeclassCandidate::underLeaders()
        if (!$this->indexExists('lifeclass_candidates', 'idx_lifeclass_member_leader')) {
            Schema::table('lifeclass_candidates', function (Blueprint $table) {
                $table->index('member_id', 'idx_lifeclass_member_leader');
            });
        }

        // Optimized for name searches (Members table)
        // Optimizes: VipMembersTable and ConsolidatorMembersTable search
        if (!$this->indexExists('members', 'idx_members_names')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index(['first_name', 'last_name'], 'idx_members_names');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop G12 Leaders indexes
        if ($this->indexExists('g12_leaders', 'idx_g12_leaders_parent_id')) {
            Schema::table('g12_leaders', function (Blueprint $table) {
                $table->dropIndex('idx_g12_leaders_parent_id');
            });
        }
        
        if ($this->indexExists('g12_leaders', 'idx_g12_leaders_user_parent')) {
            Schema::table('g12_leaders', function (Blueprint $table) {
                $table->dropIndex('idx_g12_leaders_user_parent');
            });
        }

        // Drop Members indexes
        if ($this->indexExists('members', 'idx_members_leader_type_status')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_leader_type_status');
            });
        }
        
        if ($this->indexExists('members', 'idx_members_consolidation_date')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_consolidation_date');
            });
        }
        
        if ($this->indexExists('members', 'idx_members_consolidator_leader')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_consolidator_leader');
            });
        }
        
        if ($this->indexExists('members', 'idx_members_names')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_names');
            });
        }

        // Drop StartUpYourNewLife indexes
        if ($this->indexExists('start_up_your_new_life', 'idx_suynl_member_lessons')) {
            Schema::table('start_up_your_new_life', function (Blueprint $table) {
                $table->dropIndex('idx_suynl_member_lessons');
            });
        }

        // Drop SundayService indexes
        if ($this->indexExists('sunday_services', 'idx_sunday_member_sessions')) {
            Schema::table('sunday_services', function (Blueprint $table) {
                $table->dropIndex('idx_sunday_member_sessions');
            });
        }

        // Drop CellGroup indexes
        if ($this->indexExists('cell_groups', 'idx_cell_member_sessions')) {
            Schema::table('cell_groups', function (Blueprint $table) {
                $table->dropIndex('idx_cell_member_sessions');
            });
        }

        // Drop LifeclassCandidate indexes
        if ($this->indexExists('lifeclass_candidates', 'idx_lifeclass_member_leader')) {
            Schema::table('lifeclass_candidates', function (Blueprint $table) {
                $table->dropIndex('idx_lifeclass_member_leader');
            });
        }
    }
};
