<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaTorneio extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'categorias_torneios';    

    protected $fillable = ['titulo_categoria'];

    /**
     * Relacionamentos
     */

    // Uma categoria pode ter muitos torneios
    public function torneios()
    {
        return $this->hasMany(Torneio::class, 'categoria_id');
    }

    // Uma categoria pode ter muitos times
    public function times()
    {
        return $this->hasMany(Time::class, 'categoria_id');
    }

    // Uma categoria pode ter muitas partidas
    public function partidas()
    {
        return $this->hasMany(Partida::class, 'categoria_id');
    }
}
