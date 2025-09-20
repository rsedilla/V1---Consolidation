<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class G12LeadersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('g12_leaders')->delete();
        DB::table('g12_leaders')->insert([
            ['name' => 'manuel domingo', 'user_id' => null],
            ['name' => 'Bon Ryan Fran', 'user_id' => null],
            ['name' => 'Lester De Vera', 'user_id' => null],
            ['name' => 'Ariel Katigbak', 'user_id' => null],
            ['name' => 'John Louie Arenal', 'user_id' => null],
            ['name' => 'Jhoemar Alcantara', 'user_id' => null],
            ['name' => 'John Ramil Rabe', 'user_id' => null],
            ['name' => 'Justin John Flora', 'user_id' => null],
            ['name' => 'Carlito Ballano', 'user_id' => null],
            ['name' => 'Francisco Hornilla', 'user_id' => null],
            ['name' => 'Dareen Roy Rufo', 'user_id' => null],
            ['name' => 'Phillip Wilson Grande', 'user_id' => null],
            ['name' => 'Mark Filbert Valdez', 'user_id' => null],
            ['name' => 'Jayson Din Marmol', 'user_id' => null],
        ]);
    }
}
