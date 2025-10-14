<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lifeclass_candidates', function (Blueprint $table) {
            // Make member_id nullable (was required before)
            $table->foreignId('member_id')->nullable()->change();
            
            // Add sol_profile_id column
            $table->foreignId('sol_profile_id')->nullable()->after('id')->constrained('sol_profiles')->onDelete('cascade');
            
            // Add index for faster queries
            $table->index('sol_profile_id');
        });
    }

    public function down(): void
    {
        Schema::table('lifeclass_candidates', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['sol_profile_id']);
            $table->dropIndex(['sol_profile_id']);
            $table->dropColumn('sol_profile_id');
            
            // Revert member_id to required
            $table->foreignId('member_id')->nullable(false)->change();
        });
    }
};
