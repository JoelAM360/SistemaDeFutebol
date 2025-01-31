<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TorneioTime extends Pivot
{
    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'torneios_times';

    protected $fillable = [
        'torneio_id',
        'time_id',
        'status'
    ];

    /**
     * Relacionamento com Torneio.
     */
    public function torneio()
    {
        return $this->belongsTo(Torneio::class, 'torneio_id');
    }

    /**
     * Relacionamento com Time.
     */
    public function time()
    {
        return $this->belongsTo(Time::class, 'time_id');
    }
}
