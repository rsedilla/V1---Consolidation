<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add unique constraints to prevent duplicate VIP entries within each training module
     */
    public function up(): void
    {
        // Add unique constraint to start_up_your_new_life table
        // This ensures a VIP can only have ONE record in New Life Training
        Schema::table('start_up_your_new_life', function (Blueprint $table) {
            $table->unique('member_id', 'unique_member_new_life_training');
        });

        // Add unique constraint to sunday_services table
        // This ensures a VIP can only have ONE record in Sunday Services
        Schema::table('sunday_services', function (Blueprint $table) {
            $table->unique('member_id', 'unique_member_sunday_service');
        });

        // Add unique constraint to cell_groups table
        // This ensures a VIP can only have ONE record in Cell Groups
        Schema::table('cell_groups', function (Blueprint $table) {
            $table->unique('member_id', 'unique_member_cell_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove unique constraints
        Schema::table('start_up_your_new_life', function (Blueprint $table) {
            $table->dropUnique('unique_member_new_life_training');
        });

        Schema::table('sunday_services', function (Blueprint $table) {
            $table->dropUnique('unique_member_sunday_service');
        });

        Schema::table('cell_groups', function (Blueprint $table) {
            $table->dropUnique('unique_member_cell_group');
        });
    }
};
