<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class G12LeaderSeeder extends Seeder
{
    public function run(): void
    {
        // Remove all existing records first
        DB::table('g12_leaders')->delete();

        $leaders = [
            'Ariel Katigbak',
            'Bon Ryan Fran',
            'Carlito Ballano',
            'Dareen Roy Rufo',
            'Francisco Hornilla',
            'Jayson Din Marmol',
            'Jhoemar Alcantara',
            'John Louie Arenal',
            'John Ramil Rabe',
            'Justin John Flora',
            'Lester De Vera',
            'Manuel Domingo',
            'Mark Filbert Valdez',
            'Phillip Wilson Grande',
        ];

        foreach ($leaders as $name) {
            DB::table('g12_leaders')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
