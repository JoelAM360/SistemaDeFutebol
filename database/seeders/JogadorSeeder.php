<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jogador;

class JogadorSeeder extends Seeder
{
    public function run()
    {
       /* Jogador::create([
            'user_id' => 2, // Certifique-se de que este ID corresponde a um usuário do tipo jogador
            'time_id' => 1, // Substitua pelo ID real de um time existente
            'img_perfil' => 'default.png',
            'posicao' => 'Atacante',
            'dorsal' => 9,
        ]);
*/
        Jogador::create([
            'advogado_id' => 2,
            'time_id' => 2,
            'img_perfil' => 'jogador2.png',
            'posicao' => 'Goleiro',
            'dorsal' => 10,
            'isCapitao' => 'sim'
        ]);
    }
}
