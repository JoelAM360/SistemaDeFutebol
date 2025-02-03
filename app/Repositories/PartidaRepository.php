<?php 

namespace App\Repositories;

use App\Models\Partida;

class PartidaRepository extends AbstractRepository
{
    public function __construct(Partida $model)
    {
       $this->model = $model; 
    }

    public function timesExists($dados) {
        return $this->model
            ->where('id', $dados['partida_id'])
            ->where(function ($query) use ($dados) {
                $query->where('time_id_casa', $dados['time_id'])
                    ->orWhere('time_id_fora', $dados['time_id']); 
            })
            ->first();
    }


    public function timesDeCasa($dados) {
        return $this->model
            ->where('id', $dados['partida_id'])
            ->where('time_id_casa', $dados['time_id'])
            ->exists();
    }

    public function jogadorBelongToTimeHomeOrOut($dados, $time) {
        return $this->model
            ->where('id', $dados['partida_id'])
            ->where(function ($query) use ($time) {
                $query->where('time_id_casa', $time)
                ->orWhere('time_id_fora', $time);
                })
            ->first();
    }
}