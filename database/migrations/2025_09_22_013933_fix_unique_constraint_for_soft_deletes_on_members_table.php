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
            // Drop the existing unique constraint
            $table->dropUnique('members_name_unique');
            
            // Create a new unique constraint that includes deleted_at
            // This allows the same name to exist only once among non-deleted records
            $table->unique(['first_name', 'last_name', 'deleted_at'], 'members_name_unique_with_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop the new constraint
            $table->dropUnique('members_name_unique_with_deleted');
            
            // Restore the original constraint (without deleted_at)
            $table->unique(['first_name', 'last_name'], 'members_name_unique');
        });
    }
};
