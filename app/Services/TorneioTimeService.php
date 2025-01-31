<?php
namespace App\Services;

use App\Models\Partida;
use App\Models\TorneioTime;
use App\Repositories\TorneioTimeRepository;
use Illuminate\Support\Facades\DB;

class TorneioTimeService
{
    protected $torneioTimeRepository;
    protected TorneioTime $torneioTime;

    public function __construct(TorneioTime $torneioTime)
    {
        $this->torneioTime = $torneioTime;
        $this->torneioTimeRepository = new TorneioTimeRepository($this->torneioTime);
    }
    
    public function removerTimeDoTorneio($torneioTimeID)
    {
        $torneioTime = $this->torneioTimeRepository->find($torneioTimeID);
        
        if($torneioTime === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        
        // Cancela partidas relacionadas ao time no torneio
        $this->torneioTimeRepository->cancelarPartidasDoTime(
            $torneioTime->torneio_id,
            $torneioTime->time_id
        );

        // Remove o time da tabela pivot
        $this->torneioTimeRepository->removerTime($torneioTime);

        return response()->json(['sucesso' => 'Time removido do torneio.'], 200);
    }
}