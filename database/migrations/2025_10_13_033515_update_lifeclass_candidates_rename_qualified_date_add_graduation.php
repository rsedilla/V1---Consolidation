<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Rename qualified_date to life_class_party_date (the party before Lesson 1)
     * Add graduation_date field for Life Class Graduation
     */
    public function up(): void
    {
        Schema::table('lifeclass_candidates', function (Blueprint $table) {
            // Rename qualified_date to life_class_party_date
            $table->renameColumn('qualified_date', 'life_class_party_date');
            
            // Add graduation_date field after lesson_9_completion_date
            $table->date('graduation_date')->nullable()->after('lesson_9_completion_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lifeclass_candidates', function (Blueprint $table) {
            // Remove graduation_date field
            $table->dropColumn('graduation_date');
            
            // Rename back to qualified_date
            $table->renameColumn('life_class_party_date', 'qualified_date');
        });
    }
};
