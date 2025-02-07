<?php 

namespace App\Repositories;

use App\Models\Classificacao;

class ClassificacaoRepository extends AbstractRepository
{
    public function __construct(Classificacao $model)
    {
       $this->model = $model; 
    }
}