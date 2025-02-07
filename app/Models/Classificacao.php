<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{
    use HasFactory;

    protected $table = 'classificacao';

    protected $fillable = [
        'torneio_id',
        'time_id',
        'vitorias',
        'derrotas',
        'empates',
        'gol_marcados',
        'gol_sofridos',
        'gol_diferenca',
    ];

    /**
     * Relacionamento com o torneio
     */
    public function torneio()
    {
        return $this->belongsTo(Torneio::class);
    }

    /**
     * Relacionamento com o time
     */
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}