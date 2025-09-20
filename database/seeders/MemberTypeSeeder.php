<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTypeSeeder extends Seeder
{
    public function run(): void
    {
    DB::table('member_types')->delete();
        DB::table('member_types')->insert([
            ['name' => 'VIP', 'description' => 'First timer in the church'],
            ['name' => 'Consolidator', 'description' => 'Follows up with VIPs'],
        ]);
    }
}
