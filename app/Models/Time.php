<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'categoria_id',
        'advogado_id',
        'img_escudo',
        'status'
    ];

    /**
     * Relacionamentos
     */

    // Um time pertence a uma categoria
    public function categoria()
    {
        return $this->belongsTo(CategoriaTorneio::class, 'categoria_id');
    }

    // Um time pertence a um advogado
    public function advogado()
    {
        return $this->belongsTo(Advogado::class, 'advogado_id');
    }

    //Um time pode ter um ou muitos jogadores:
    public function jogadores()
    {
        return $this->hasMany(Jogador::class, 'time_id');
    }

    // Um time pode participar de muitos torneios
    public function torneios()
    {
        return $this->belongsToMany(Torneio::class, 'torneios_times');
    }

    // Um time pode estar em muitas partidas como casa ou fora
    public function partidasCasa()
    {
        return $this->hasMany(Partida::class, 'time_id_casa');
    }

    public function partidasFora()
    {
        return $this->hasMany(Partida::class, 'time_id_fora');
    }
}