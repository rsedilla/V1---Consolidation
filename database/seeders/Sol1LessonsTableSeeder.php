<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Sol1LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sol_1_lessons')->delete();
        
        $lessons = [
            ['lesson_number' => 1, 'title' => 'SOL 1 - Lesson 1', 'description' => null],
            ['lesson_number' => 2, 'title' => 'SOL 1 - Lesson 2', 'description' => null],
            ['lesson_number' => 3, 'title' => 'SOL 1 - Lesson 3', 'description' => null],
            ['lesson_number' => 4, 'title' => 'SOL 1 - Lesson 4', 'description' => null],
            ['lesson_number' => 5, 'title' => 'SOL 1 - Lesson 5', 'description' => null],
            ['lesson_number' => 6, 'title' => 'SOL 1 - Lesson 6', 'description' => null],
            ['lesson_number' => 7, 'title' => 'SOL 1 - Lesson 7', 'description' => null],
            ['lesson_number' => 8, 'title' => 'SOL 1 - Lesson 8', 'description' => null],
            ['lesson_number' => 9, 'title' => 'SOL 1 - Lesson 9', 'description' => null],
            ['lesson_number' => 10, 'title' => 'SOL 1 - Lesson 10', 'description' => null],
        ];

        foreach ($lessons as $lesson) {
            DB::table('sol_1_lessons')->insert([
                'lesson_number' => $lesson['lesson_number'],
                'title' => $lesson['title'],
                'description' => $lesson['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
