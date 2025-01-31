<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advogado extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numero_inscricao',
        'status',
    ];

    /**
     * Relacionamentos
     */

    // Relacionamento com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Relacionamento com o modelo time
    public function time()
    {
        return $this->hasOne(Time::class);
    }

    // Relacionamento para Jogador
    public function jogador()
    {
        return $this->hasOne(Jogador::class);
    }
}
