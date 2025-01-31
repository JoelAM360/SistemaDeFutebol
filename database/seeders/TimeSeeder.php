<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Time;

class TimeSeeder extends Seeder
{
    public function run()
    {
        Time::create([
            'categoria_id' => 1,
            'advogado_id' => 2,
            'img_escudo' => 'escudo_time_b.png',
        ]);
    }
}
