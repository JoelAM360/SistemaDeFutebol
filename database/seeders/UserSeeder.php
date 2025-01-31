<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nome' => 'Jogador User 2',
            'email' => 'jogador2@example.com',
            'password' => Hash::make('password'),
            'tipo_de_user' => 'advogado',
        ]);

        User::create([
            'nome' => 'Advogado User 2',
            'email' => 'advogado2@example.com',
            'password' => Hash::make('password'),
            'tipo_de_user' => 'advogado',
        ]);
    }
}
