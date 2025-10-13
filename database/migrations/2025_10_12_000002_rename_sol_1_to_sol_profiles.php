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
        // Rename the table
        Schema::rename('sol_1', 'sol_profiles');
        
        // Add current_sol_level_id column
        Schema::table('sol_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('current_sol_level_id')->nullable()->after('member_id');
            $table->foreign('current_sol_level_id')->references('id')->on('sol_levels')->onDelete('set null');
            $table->index('current_sol_level_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign key and column
        Schema::table('sol_profiles', function (Blueprint $table) {
            $table->dropForeign(['current_sol_level_id']);
            $table->dropColumn('current_sol_level_id');
        });
        
        // Rename back
        Schema::rename('sol_profiles', 'sol_1');
    }
};
