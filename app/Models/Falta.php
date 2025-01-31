<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{
    use HasFactory;

    protected $fillable = [
        'partida_id',
        'tempo',
        'time_id',
        'jogador_id',
        'tipo_de_falta',
        'cartao',
    ];

    /**
     * Relacionamento com a partida.
     */
    public function partida()
    {
        return $this->belongsTo(Partida::class);
    }

    /**
     * Relacionamento com o time.
     */
    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    /**
     * Relacionamento com o jogador que cometeu a falta.
     */
    public function jogador()
    {
        return $this->belongsTo(Jogador::class);
    }
}
