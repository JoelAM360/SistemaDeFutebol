<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advogado;

class AdvogadoSeeder extends Seeder
{
    public function run()
    {
        Advogado::create([
            'user_id' => 1,
            'numero_inscricao' => '987654321',
        ]);
    }
}
