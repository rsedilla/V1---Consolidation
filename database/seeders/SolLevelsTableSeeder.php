<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sol_levels')->insert([
            [
                'level_number' => 1,
                'level_name' => 'SOL 1',
                'description' => 'School of Leaders Level 1 - Foundation training with 10 core lessons',
                'lesson_count' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_number' => 2,
                'level_name' => 'SOL 2',
                'description' => 'School of Leaders Level 2 - Intermediate leadership training',
                'lesson_count' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_number' => 3,
                'level_name' => 'SOL 3',
                'description' => 'School of Leaders Level 3 - Advanced leadership and mentoring',
                'lesson_count' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_number' => 4,
                'level_name' => 'SOL Grad',
                'description' => 'School of Leaders Graduate - Completed all SOL training levels',
                'lesson_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
