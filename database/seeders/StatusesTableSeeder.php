<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('statuses')->delete();
        DB::table('statuses')->insert([
            ['name' => 'single'],
            ['name' => 'married'],
            ['name' => 'widowed'],
        ]);
    }
}
