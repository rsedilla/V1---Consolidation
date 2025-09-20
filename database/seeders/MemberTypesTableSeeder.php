<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('member_types')->delete();
        DB::table('member_types')->insert([
            ['name' => 'VIP', 'description' => 'Very Important Person'],
            ['name' => 'Consolidator', 'description' => 'Consolidator'],
        ]);
    }
}
