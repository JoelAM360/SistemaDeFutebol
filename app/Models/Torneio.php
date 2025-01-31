<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneio extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'nome',
        'jornadas',
        'quantidade_times',
        'img_icon',
        'data_inicio',
        'data_termino',
        'status'
    ];

    /**
     * Relacionamentos
     */

    // Um torneio pertence a uma categoria
    public function categoria()
    {
        return $this->belongsTo(CategoriaTorneio::class, 'categoria_id');
    }

    // Um torneio pode ter muitas partidas
    public function partidas()
    {
        return $this->hasMany(Partida::class, 'torneio_id');
    }

    // Um torneio pode ter muitos times
    public function times()
    {
        return $this->belongsToMany(Time::class, 'torneios_times');
    }
}
