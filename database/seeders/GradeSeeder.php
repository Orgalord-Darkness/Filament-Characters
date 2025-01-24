<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('grades')->insert([
            ['libelle' => 'Recrue',
            'abilitation'=> 'None',
            'description' => 'Les recrues se forment à devenir soldat', 
            'color' => '#e3e3e3', 
            'text_color' => '#303030', 
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['libelle' => 'Soldat', 
            'abilitation'=> 'None',
            'description' => 'Les soldats obéissent aux officiers et gagnent en expérience', 
            'color' => '##9c9c9c', 
            'text_color' => '#303030', 
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]) ; 
    }
}
