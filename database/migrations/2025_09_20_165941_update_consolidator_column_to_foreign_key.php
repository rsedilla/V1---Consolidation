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
            // Drop the old string column
            $table->dropColumn('consolidator');
            
            // Add new foreign key column
            $table->unsignedBigInteger('consolidator_id')->nullable()->after('g12_leader_id');
            $table->foreign('consolidator_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['consolidator_id']);
            $table->dropColumn('consolidator_id');
            
            // Restore old string column
            $table->string('consolidator')->nullable()->after('g12_leader_id');
        });
    }
};
