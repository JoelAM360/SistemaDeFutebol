<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jogador extends Model
{
    use HasFactory;

     /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'jogadores';

    protected $fillable = [
        'nome',
        'advogado_id',
        'time_id',
        'img_perfil',
        'posicao',
        'dorsal',
        'isCapitao'
    ];

    /**
     * Relacionamento com o usuário (1 para 1).
     */
    public function advogado()
    {
        return $this->belongsTo(Advogado::class);
    }

    /**
     * Relacionamento com o time (1 para N).
     */
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}