<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StartUpYourNewLifeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('start_up_your_new_life')->delete();
        $memberIds = DB::table('members')->pluck('id');
        foreach ($memberIds as $memberId) {
            // Create one record per member with all lesson completion dates as nullable
            DB::table('start_up_your_new_life')->insert([
                'member_id' => $memberId,
                'notes' => null,
                'lesson_1_completion_date' => null,
                'lesson_2_completion_date' => null,
                'lesson_3_completion_date' => null,
                'lesson_4_completion_date' => null,
                'lesson_5_completion_date' => null,
                'lesson_6_completion_date' => null,
                'lesson_7_completion_date' => null,
                'lesson_8_completion_date' => null,
                'lesson_9_completion_date' => null,
                'lesson_10_completion_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
