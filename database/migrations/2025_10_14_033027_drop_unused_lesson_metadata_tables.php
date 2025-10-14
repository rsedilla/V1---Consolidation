<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Drop unused lesson metadata tables. These tables were created for storing
     * lesson titles and descriptions, but the application uses direct date tracking
     * in the candidate tables instead (e.g., lesson_1_completion_date).
     * 
     * Related models removed:
     * - LifeClassLesson.php (deleted)
     * - Sol1Lesson.php (deleted)
     */
    public function up(): void
    {
        Schema::dropIfExists('life_class_lessons');
        Schema::dropIfExists('sol_1_lessons');
    }

    /**
     * Reverse the migrations.
     * 
     * Recreate the tables in case rollback is needed.
     */
    public function down(): void
    {
        // Recreate life_class_lessons table
        Schema::create('life_class_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('lesson_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Recreate sol_1_lessons table
        Schema::create('sol_1_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('lesson_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
};
