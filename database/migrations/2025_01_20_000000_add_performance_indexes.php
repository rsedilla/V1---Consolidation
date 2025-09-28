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
     */
    public function up(): void
    {
        // Check and create indexes for members table
        if (!$this->indexExists('members', 'idx_members_status_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index('status_id', 'idx_members_status_id');
            });
        }
        
        if (!$this->indexExists('members', 'idx_members_member_type_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index('member_type_id', 'idx_members_member_type_id');
            });
        }
        
        if (!$this->indexExists('members', 'idx_members_g12_leader_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index('g12_leader_id', 'idx_members_g12_leader_id');
            });
        }
        
        if (!$this->indexExists('members', 'idx_members_consolidator_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index('consolidator_id', 'idx_members_consolidator_id');
            });
        }
        
        if (!$this->indexExists('members', 'idx_members_vip_status_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index('vip_status_id', 'idx_members_vip_status_id');
            });
        }
        
        if (!$this->indexExists('members', 'idx_members_type_status')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index(['member_type_id', 'status_id'], 'idx_members_type_status');
            });
        }
        
        if (!$this->indexExists('members', 'idx_members_leader_type')) {
            Schema::table('members', function (Blueprint $table) {
                $table->index(['g12_leader_id', 'member_type_id'], 'idx_members_leader_type');
            });
        }

        // Check and create indexes for sunday_services table
        if (!$this->indexExists('sunday_services', 'idx_sunday_services_member_id')) {
            Schema::table('sunday_services', function (Blueprint $table) {
                $table->index('member_id', 'idx_sunday_services_member_id');
            });
        }
        
        if (!$this->indexExists('sunday_services', 'idx_sunday_services_service_date')) {
            Schema::table('sunday_services', function (Blueprint $table) {
                $table->index('service_date', 'idx_sunday_services_service_date');
            });
        }
        
        if (!$this->indexExists('sunday_services', 'idx_sunday_services_member_service_date')) {
            Schema::table('sunday_services', function (Blueprint $table) {
                $table->index(['member_id', 'service_date'], 'idx_sunday_services_member_service_date');
            });
        }

        // Check and create indexes for cell_groups table
        if (!$this->indexExists('cell_groups', 'idx_cell_groups_member_id')) {
            Schema::table('cell_groups', function (Blueprint $table) {
                $table->index('member_id', 'idx_cell_groups_member_id');
            });
        }
        
        if (!$this->indexExists('cell_groups', 'idx_cell_groups_attendance_date')) {
            Schema::table('cell_groups', function (Blueprint $table) {
                $table->index('attendance_date', 'idx_cell_groups_attendance_date');
            });
        }
        
        if (!$this->indexExists('cell_groups', 'idx_cell_groups_member_attendance_date')) {
            Schema::table('cell_groups', function (Blueprint $table) {
                $table->index(['member_id', 'attendance_date'], 'idx_cell_groups_member_attendance_date');
            });
        }

        // Check and create indexes for start_up_your_new_life table
        if (!$this->indexExists('start_up_your_new_life', 'idx_suynl_member_id')) {
            Schema::table('start_up_your_new_life', function (Blueprint $table) {
                $table->index('member_id', 'idx_suynl_member_id');
            });
        }
        
        if (!$this->indexExists('start_up_your_new_life', 'idx_suynl_member_date')) {
            Schema::table('start_up_your_new_life', function (Blueprint $table) {
                $table->index(['member_id', 'lesson_date'], 'idx_suynl_member_date');
            });
        }

        // Check and create indexes for lifeclass_candidates table
        if (!$this->indexExists('lifeclass_candidates', 'idx_lifeclass_member_id')) {
            Schema::table('lifeclass_candidates', function (Blueprint $table) {
                $table->index('member_id', 'idx_lifeclass_member_id');
            });
        }
        
        if (!$this->indexExists('lifeclass_candidates', 'idx_lifeclass_status')) {
            Schema::table('lifeclass_candidates', function (Blueprint $table) {
                $table->index('status', 'idx_lifeclass_status');
            });
        }

        // Check and create indexes for users table
        if (!$this->indexExists('users', 'idx_users_g12_leader_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index('g12_leader_id', 'idx_users_g12_leader_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes for members table if they exist
        if ($this->indexExists('members', 'idx_members_status_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_status_id');
            });
        }
        if ($this->indexExists('members', 'idx_members_member_type_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_member_type_id');
            });
        }
        if ($this->indexExists('members', 'idx_members_g12_leader_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_g12_leader_id');
            });
        }
        if ($this->indexExists('members', 'idx_members_consolidator_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_consolidator_id');
            });
        }
        if ($this->indexExists('members', 'idx_members_vip_status_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_vip_status_id');
            });
        }
        if ($this->indexExists('members', 'idx_members_type_status')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_type_status');
            });
        }
        if ($this->indexExists('members', 'idx_members_leader_type')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('idx_members_leader_type');
            });
        }

        // Drop indexes for sunday_services table if they exist
        if ($this->indexExists('sunday_services', 'idx_sunday_services_member_id')) {
            Schema::table('sunday_services', function (Blueprint $table) {
                $table->dropIndex('idx_sunday_services_member_id');
            });
        }
        if ($this->indexExists('sunday_services', 'idx_sunday_services_service_date')) {
            Schema::table('sunday_services', function (Blueprint $table) {
                $table->dropIndex('idx_sunday_services_service_date');
            });
        }
        if ($this->indexExists('sunday_services', 'idx_sunday_services_member_service_date')) {
            Schema::table('sunday_services', function (Blueprint $table) {
                $table->dropIndex('idx_sunday_services_member_service_date');
            });
        }

        // Drop indexes for cell_groups table if they exist
        if ($this->indexExists('cell_groups', 'idx_cell_groups_member_id')) {
            Schema::table('cell_groups', function (Blueprint $table) {
                $table->dropIndex('idx_cell_groups_member_id');
            });
        }
        if ($this->indexExists('cell_groups', 'idx_cell_groups_attendance_date')) {
            Schema::table('cell_groups', function (Blueprint $table) {
                $table->dropIndex('idx_cell_groups_attendance_date');
            });
        }
        if ($this->indexExists('cell_groups', 'idx_cell_groups_member_attendance_date')) {
            Schema::table('cell_groups', function (Blueprint $table) {
                $table->dropIndex('idx_cell_groups_member_attendance_date');
            });
        }

        // Drop indexes for start_up_your_new_life table if they exist
        if ($this->indexExists('start_up_your_new_life', 'idx_suynl_member_id')) {
            Schema::table('start_up_your_new_life', function (Blueprint $table) {
                $table->dropIndex('idx_suynl_member_id');
            });
        }
        if ($this->indexExists('start_up_your_new_life', 'idx_suynl_member_date')) {
            Schema::table('start_up_your_new_life', function (Blueprint $table) {
                $table->dropIndex('idx_suynl_member_date');
            });
        }

        // Drop indexes for lifeclass_candidates table if they exist
        if ($this->indexExists('lifeclass_candidates', 'idx_lifeclass_member_id')) {
            Schema::table('lifeclass_candidates', function (Blueprint $table) {
                $table->dropIndex('idx_lifeclass_member_id');
            });
        }
        if ($this->indexExists('lifeclass_candidates', 'idx_lifeclass_status')) {
            Schema::table('lifeclass_candidates', function (Blueprint $table) {
                $table->dropIndex('idx_lifeclass_status');
            });
        }

        // Drop indexes for users table if they exist
        if ($this->indexExists('users', 'idx_users_g12_leader_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex('idx_users_g12_leader_id');
            });
        }
    }
};