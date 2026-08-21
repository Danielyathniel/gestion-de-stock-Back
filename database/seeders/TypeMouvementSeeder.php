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
        TypeMouvement::firstOrCreate(['code' => 'IN'], ['id' => 1, 'libelle' => 'Entrée', 'created_at' => $now, 'updated_at' => $now]);
        TypeMouvement::firstOrCreate(['code' => 'OUT'], ['id' => 2, 'libelle' => 'Sortie', 'created_at' => $now, 'updated_at' => $now]);
    }
}
