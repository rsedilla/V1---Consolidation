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
        Schema::create('sol_levels', function (Blueprint $table) {
            $table->id();
            $table->integer('level_number')->unique()->comment('1, 2, 3');
            $table->string('level_name')->unique()->comment('SOL 1, SOL 2, SOL 3');
            $table->text('description')->nullable();
            $table->integer('lesson_count')->default(10)->comment('Number of lessons for this level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sol_levels');
    }
};
