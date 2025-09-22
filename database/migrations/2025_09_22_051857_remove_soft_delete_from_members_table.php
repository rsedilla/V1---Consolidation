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
        Schema::table('members', function (Blueprint $table) {
            // Add simple unique constraint on first_name + last_name
            $table->unique(['first_name', 'last_name'], 'members_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Remove the simple unique constraint
            $table->dropUnique('members_name_unique');
            
            // Add back the soft delete and computed columns
            $table->timestamp('deleted_at')->nullable();
            $table->string('active_name_key')->nullable();
            
            // Restore the active_name_key unique constraint
            $table->unique('active_name_key', 'members_active_name_unique');
        });
    }
};
