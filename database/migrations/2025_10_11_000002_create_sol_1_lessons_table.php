<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Reference table for SOL 1 lesson titles and descriptions
     */
    public function up(): void
    {
        Schema::create('sol_1_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('lesson_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sol_1_lessons');
    }
};
