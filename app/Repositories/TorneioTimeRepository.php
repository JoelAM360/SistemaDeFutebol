<?php 

namespace App\Repositories;
use App\Models\Partida;
use App\Models\TorneioTime;

class TorneioTimeRepository extends AbstractRepository
{
    public function cancelarPartidasDoTime(int $torneioId, int $timeId): void
    {
        Partida::where('torneio_id', $torneioId)
            ->where(function ($query) use ($timeId) {
                $query->where('time_id_casa', $timeId)
                      ->orWhere('time_id_fora', $timeId);
            })
            ->update(['status' => 'cancelada']);
    }

    public function removerTime(TorneioTime $torneioTime): void
    {
        $torneioTime->delete();
    }
}