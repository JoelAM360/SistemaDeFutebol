<?php

namespace App\Http\Controllers;

use App\Models\Advogado;
use App\Models\Jogador;
use App\Models\User;
use App\Repositories\JogadorRepository;
use Illuminate\Http\Request;
use App\Http\Requests\JogadorRequest;

class JogadorController extends BaseController
{

    private Jogador $jogador;
    private JogadorRepository $jogadorRepository;

    public function __construct(Jogador $jogador)
    {
        $this->jogador = $jogador;
        $this->jogadorRepository = new JogadorRepository($this->jogador); 
        parent::__construct($this->jogadorRepository, 'time');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JogadorRequest $request)
    {
        #dd($request->validated());
        $jog = $this->jogadorRepository->store($request->validated());
        return response()->json($jog, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JogadorRequest $request, string $id)
    {
        #dd($request->validated());
        $jog = $this->jogadorRepository->update($id,$request->validated());
        return response()->json($jog, 200);
    }
}