<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            ['name' => 'Admin', 'description' => 'System administrator'],
            ['name' => 'Leader', 'description' => 'G12 leader'],
        ]);
    }
}
