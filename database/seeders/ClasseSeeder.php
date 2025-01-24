<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classes')->insert([
            ['name' => 'Guerrier',
            'description'=> 'Combattant au corps à corps avec une arme. Le seul moyen pour eux de combattres 
             avec la magie est de détenir une arme enchantée ou alchimique. Ils ont plusieurs sous catégorie',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['name' => 'Sorcier', 
            'description' => 'érudit de la sorcellerie, ils étudient les langues magiques et géométrie des sorts,
             ils ont plusieurs sous catégorie',
            'created_at' => now(),
            'updated_at' => now(),
            ], 
        ]) ; 
    }
}
