<?php

namespace Database\Seeders;
use App\Models\TypeMouvement;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeMouvementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        TypeMouvement::insert([
            ['id' => 1, 'libelle' => 'Entrée', 'code' => 'IN', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'libelle' => 'Sortie', 'code' => 'OUT', 'created_at' => $now, 'updated_at' => $now],
        ]);
        
    }
}
