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
            // Add a computed column that combines name with deletion status
            // This will be unique for active members only
            $table->string('active_name_key')->nullable()->after('last_name');
        });
        
        // Create a unique index on the computed column
        Schema::table('members', function (Blueprint $table) {
            $table->unique('active_name_key', 'members_active_name_unique');
        });
        
        // Update existing records to populate the computed column
        DB::statement("
            UPDATE members 
            SET active_name_key = CASE 
                WHEN deleted_at IS NULL 
                THEN CONCAT(first_name, '|', last_name)
                ELSE NULL
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop the computed column and its index
            $table->dropUnique('members_active_name_unique');
            $table->dropColumn('active_name_key');
        });
    }
};
