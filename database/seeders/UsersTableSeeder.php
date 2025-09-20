<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'rsedilla@gmail.com',
                'password' => Hash::make('monmon'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manuel domingo',
                'email' => 'manuel_domingojr@dlsu.edu.ph',
                'password' => Hash::make('manuel'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
