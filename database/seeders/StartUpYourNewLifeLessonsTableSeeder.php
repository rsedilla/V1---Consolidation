<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StartUpYourNewLifeLessonsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('start_up_your_new_life_lessons')->delete();
        for ($i = 1; $i <= 10; $i++) {
            DB::table('start_up_your_new_life_lessons')->insert([
                'lesson_number' => $i,
                'title' => 'Lesson ' . $i,
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
