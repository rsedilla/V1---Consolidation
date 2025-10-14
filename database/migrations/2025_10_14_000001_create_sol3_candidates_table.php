<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sol3_candidates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sol_profile_id');
            $table->date('enrollment_date')->nullable();
            $table->date('lesson_1_completion_date')->nullable();
            $table->date('lesson_2_completion_date')->nullable();
            $table->date('lesson_3_completion_date')->nullable();
            $table->date('lesson_4_completion_date')->nullable();
            $table->date('lesson_5_completion_date')->nullable();
            $table->date('lesson_6_completion_date')->nullable();
            $table->date('lesson_7_completion_date')->nullable();
            $table->date('lesson_8_completion_date')->nullable();
            $table->date('lesson_9_completion_date')->nullable();
            $table->date('lesson_10_completion_date')->nullable();
            $table->date('graduation_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('sol_profile_id')->references('id')->on('sol_profiles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sol3_candidates');
    }
};
