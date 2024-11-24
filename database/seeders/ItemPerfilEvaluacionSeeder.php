<?php

namespace Database\Seeders;

use App\Models\ItemPerfilEvaluacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemPerfilEvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            'Crítico',
            'Condicionante',
            'General',
            'Especifico'
        ];

        foreach ($items as $item) {
            ItemPerfilEvaluacion::create(['nombre' => $item]);
        }
    }
}
