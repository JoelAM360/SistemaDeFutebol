<?php 

namespace App\Repositories;

use App\Models\Jogador;

class JogadorRepository extends AbstractRepository
{
    public function __construct(Jogador $model)
    {
       $this->model = $model; 
    }

    public function findJogadorWithTimeById($id) {
        return $this->model->with(['time'])->find($id);
    } 
}