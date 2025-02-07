<?php

namespace App\Http\Controllers;

use App\Models\Classificacao;
use App\Repositories\ClassificacaoRepository;
use Illuminate\Http\Request;

class ClassificacaoController extends BaseController
{

    private Classificacao $classificacao; 

    private ClassificacaoRepository $classificacaoRepository;

    public function __construct(Classificacao $classificacao) {
        $this->classificacao = $classificacao;
        $this->classificacaoRepository = new ClassificacaoRepository($this->classificacao);
        parent::__construct($this->classificacaoRepository, 'torneios');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->classificacaoRepository->store($request->all());
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classificacao $classificacao)
    {
        //
    }

}