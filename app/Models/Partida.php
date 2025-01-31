<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'torneio_id',
        'time_id_casa',
        'time_id_fora',
        'resultado',
        'local',
        'gol_casa',
        'gol_fora',
        'data_marcada',
        'status',
    ];

    /**
     * Relacionamentos
     */
    // Uma partida pertence a uma categoria
    public function categoria()
    {
        return $this->belongsTo(CategoriaTorneio::class, 'categoria_id');
    }

    // Uma partida pertence a um torneio
    public function torneio()
    {
        return $this->belongsTo(Torneio::class, 'torneio_id');
    }

    // Uma partida tem dois times (casa e fora)
    public function timeCasa()
    {
        return $this->belongsTo(Time::class, 'time_id_casa');
    }

    public function timeFora()
    {
        return $this->belongsTo(Time::class, 'time_id_fora');
    }
}
