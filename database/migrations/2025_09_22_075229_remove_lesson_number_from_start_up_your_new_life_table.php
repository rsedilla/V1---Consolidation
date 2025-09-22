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
        Schema::table('start_up_your_new_life', function (Blueprint $table) {
            // Remove the obsolete lesson_number column since we now use individual lesson completion date columns
            $table->dropColumn(['lesson_number', 'completion_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('start_up_your_new_life', function (Blueprint $table) {
            // Add back the columns if rollback is needed
            $table->unsignedTinyInteger('lesson_number')->after('member_id');
            $table->date('completion_date')->nullable()->after('lesson_number');
        });
    }
};
