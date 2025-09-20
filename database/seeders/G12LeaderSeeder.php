<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class G12LeaderSeeder extends Seeder
{
    public function run(): void
    {
    // Remove all existing records first
    DB::table('g12_leaders')->truncate();

    $leaders = [
            'Manuel Domingo',
            'Bon Ryan Fran',
            'Lester De Vera',
            'Ariel Katigbak',
            'John Louie Arenal',
            'Jhoemar Alcantara',
            'John Ramil Rabe',
            'Justin John Flora',
            'Carlito Ballano',
            'Francisco Hornilla',
            'Phillip Wilson Grande',
            'Mark Filbert Valdez',
            'Jayson Din Marmol',
            'Dareen Roy Rufo',
        ];

        foreach ($leaders as $name) {
            DB::table('g12_leaders')->insert(['name' => $name]);
        }
    }
}
