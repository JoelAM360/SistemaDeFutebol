<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaTorneio;

class CategoriaTorneioSeeder extends Seeder
{
    public function run()
    {
        CategoriaTorneio::create([
            'titulo_categoria' => 'Categoria A',
        ]);

        CategoriaTorneio::create([
            'titulo_categoria' => 'Categoria B',
        ]);

        CategoriaTorneio::create([
            'titulo_categoria' => 'Categoria C',
        ]);
    }
}
