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
            // Drop existing foreign key constraint
            $table->dropForeign(['consolidator_id']);
            
            // Add foreign key with proper cascade rules
            $table->foreign('consolidator_id')
                  ->references('id')
                  ->on('members')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop the updated foreign key
            $table->dropForeign(['consolidator_id']);
            
            // Restore original foreign key without cascade rules
            $table->foreign('consolidator_id')
                  ->references('id')
                  ->on('members');
        });
    }
};
