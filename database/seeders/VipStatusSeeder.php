<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VipStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    DB::table('vip_statuses')->insert([
            ['name' => 'New Believer'],
            ['name' => 'Recommitment'],
            ['name' => 'Other Church'],
        ]);
    }
}
