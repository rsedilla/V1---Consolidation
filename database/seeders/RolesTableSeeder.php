<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'g12 leader', 'description' => 'G12 Leader'],
        ]);
    }
}
