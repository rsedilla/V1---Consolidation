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
            for ($lesson = 1; $lesson <= 10; $lesson++) {
                DB::table('start_up_your_new_life')->insert([
                    'member_id' => $memberId,
                    'lesson_number' => $lesson,
                    'completion_date' => null,
                    'notes' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
