<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gol extends Model
{
    use HasFactory;

    protected $fillable = [
        'partida_id',
        'tempo',
        'time_id',
        'jogador_id_marcador',
        'jogador_id_assitente',
        'tipo_de_gol',
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
     * Relacionamento com o jogador que marcou o gol.
     */
    public function marcador()
    {
        return $this->belongsTo(Jogador::class, 'jogador_id_marcador');
    }

    /**
     * Relacionamento com o jogador que deu assistência (opcional).
     */
    public function assistente()
    {
        return $this->belongsTo(Jogador::class, 'jogador_id_assitente');
    }
}
