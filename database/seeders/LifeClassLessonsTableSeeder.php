<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LifeClassLessonsTableSeeder extends Seeder
{
    /**
     * Seed the life_class_lessons table with 9 lessons
     * Lesson 5 is titled "Encounter" instead of "Lesson 5"
     */
    public function run()
    {
        DB::table('life_class_lessons')->delete();
        
        $lessons = [
            ['lesson_number' => 1, 'title' => 'Lesson 1', 'description' => null],
            ['lesson_number' => 2, 'title' => 'Lesson 2', 'description' => null],
            ['lesson_number' => 3, 'title' => 'Lesson 3', 'description' => null],
            ['lesson_number' => 4, 'title' => 'Lesson 4', 'description' => null],
            ['lesson_number' => 5, 'title' => 'Encounter', 'description' => 'Life Class Encounter Session'],
            ['lesson_number' => 6, 'title' => 'Lesson 6', 'description' => null],
            ['lesson_number' => 7, 'title' => 'Lesson 7', 'description' => null],
            ['lesson_number' => 8, 'title' => 'Lesson 8', 'description' => null],
            ['lesson_number' => 9, 'title' => 'Lesson 9', 'description' => null],
        ];

        foreach ($lessons as $lesson) {
            DB::table('life_class_lessons')->insert([
                'lesson_number' => $lesson['lesson_number'],
                'title' => $lesson['title'],
                'description' => $lesson['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
