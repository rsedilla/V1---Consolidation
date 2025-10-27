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
        // Add SOL Grad level (level 4)
        DB::table('sol_levels')->insert([
            'id' => 4,
            'level_number' => 4,
            'level_name' => 'SOL Grad',
            'description' => 'School of Leaders Graduate - Completed all SOL training levels',
            'lesson_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove SOL Grad level
        DB::table('sol_levels')->where('level_number', 4)->delete();
    }
};
