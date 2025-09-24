<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Foreign key indexes for better JOIN performance
            $table->index('status_id', 'idx_members_status_id');
            $table->index('member_type_id', 'idx_members_member_type_id');
            $table->index('g12_leader_id', 'idx_members_g12_leader_id');
            $table->index('consolidator_id', 'idx_members_consolidator_id');
            $table->index('vip_status_id', 'idx_members_vip_status_id');
            
            // Composite index for common filter combinations
            $table->index(['member_type_id', 'status_id'], 'idx_members_type_status');
            $table->index(['g12_leader_id', 'member_type_id'], 'idx_members_leader_type');
        });

        Schema::table('sunday_services', function (Blueprint $table) {
            $table->index('member_id', 'idx_sunday_services_member_id');
            $table->index('date', 'idx_sunday_services_date');
            $table->index(['member_id', 'date'], 'idx_sunday_services_member_date');
        });

        Schema::table('cell_groups', function (Blueprint $table) {
            $table->index('member_id', 'idx_cell_groups_member_id');
            $table->index('date', 'idx_cell_groups_date');
            $table->index(['member_id', 'date'], 'idx_cell_groups_member_date');
        });

        Schema::table('start_up_your_new_life', function (Blueprint $table) {
            $table->index('member_id', 'idx_suynl_member_id');
            $table->index(['member_id', 'lesson_date'], 'idx_suynl_member_date');
        });

        Schema::table('lifeclass_candidates', function (Blueprint $table) {
            $table->index('member_id', 'idx_lifeclass_member_id');
            $table->index('status', 'idx_lifeclass_status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('g12_leader_id', 'idx_users_g12_leader_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropIndex('idx_members_status_id');
            $table->dropIndex('idx_members_member_type_id');
            $table->dropIndex('idx_members_g12_leader_id');
            $table->dropIndex('idx_members_consolidator_id');
            $table->dropIndex('idx_members_vip_status_id');
            $table->dropIndex('idx_members_type_status');
            $table->dropIndex('idx_members_leader_type');
        });

        Schema::table('sunday_services', function (Blueprint $table) {
            $table->dropIndex('idx_sunday_services_member_id');
            $table->dropIndex('idx_sunday_services_date');
            $table->dropIndex('idx_sunday_services_member_date');
        });

        Schema::table('cell_groups', function (Blueprint $table) {
            $table->dropIndex('idx_cell_groups_member_id');
            $table->dropIndex('idx_cell_groups_date');
            $table->dropIndex('idx_cell_groups_member_date');
        });

        Schema::table('start_up_your_new_life', function (Blueprint $table) {
            $table->dropIndex('idx_suynl_member_id');
            $table->dropIndex('idx_suynl_member_date');
        });

        Schema::table('lifeclass_candidates', function (Blueprint $table) {
            $table->dropIndex('idx_lifeclass_member_id');
            $table->dropIndex('idx_lifeclass_status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_g12_leader_id');
        });
    }
};