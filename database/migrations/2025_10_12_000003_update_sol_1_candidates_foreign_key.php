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
        Schema::table('sol_1_candidates', function (Blueprint $table) {
            // Drop old foreign key
            $table->dropForeign(['sol_1_id']);
            
            // Rename column
            $table->renameColumn('sol_1_id', 'sol_profile_id');
        });
        
        // Add new foreign key with correct reference
        Schema::table('sol_1_candidates', function (Blueprint $table) {
            $table->foreign('sol_profile_id')->references('id')->on('sol_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sol_1_candidates', function (Blueprint $table) {
            // Drop new foreign key
            $table->dropForeign(['sol_profile_id']);
            
            // Rename back
            $table->renameColumn('sol_profile_id', 'sol_1_id');
        });
        
        // Add old foreign key back
        Schema::table('sol_1_candidates', function (Blueprint $table) {
            $table->foreign('sol_1_id')->references('id')->on('sol_1')->onDelete('cascade');
        });
    }
};
