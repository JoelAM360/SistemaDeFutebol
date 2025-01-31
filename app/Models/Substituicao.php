<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substituicao extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'substituicoes';

    protected $fillable = [
        'partida_id',
        'tempo',
        'time_id',
        'jogador_id_sai',
        'jogador_id_entra',
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
     * Relacionamento com o jogador que saiu.
     */
    public function jogadorSai()
    {
        return $this->belongsTo(Jogador::class, 'jogador_id_sai');
    }

    /**
     * Relacionamento com o jogador que entrou.
     */
    public function jogadorEntra()
    {
        return $this->belongsTo(Jogador::class, 'jogador_id_entra');
    }
}
