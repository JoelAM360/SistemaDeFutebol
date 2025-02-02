<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Repositories\PartidaRepository;
use Illuminate\Http\Request;
use App\Http\Requests\PartidaRequest;

class PartidaController extends BaseController
{
    private Partida $partida;
    private PartidaRepository $partidaRepository;

    public function __construct(partida $partida)
    {
        $this->partida = $partida;
        $this->partidaRepository = new partidaRepository($this->partida); 
        parent::__construct($this->partidaRepository, 'torneio');
    }

    public function index(Request $request)
    {     
        $this->getValuesByFilter();
        $partidas = $this->repository->model;
        
        $partidas->with(['timeCasa', 'timeFora']);

        return response()->json($this->repository->getModel(), 200);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(PartidaRequest $request)
    {
        if($request->time_id_fora == $request->torneio_id) {
            return response()->json(['erro' => 'Seleciona times diferentes'], 404) ;
        }

        //Verificando se partida já foi cadastrada:
        $partida_exits = Partida::where('time_id_casa', $request->time_id_casa)
        ->where('time_id_fora', $request->time_id_fora)
        ->where('torneio_id', $request->torneio_id)
        ->first();

        if($partida_exits) {
             return response()->json(['erro' => 'Está partida já foi agendada'], 404) ;
        }
        
        $partida = $this->partidaRepository->store($request->all());
        return response()->json($partida, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartidaRequest $request, string $id)
    {
        if($request->time_id_fora == $request->torneio_id) {
            return response()->json(['erro' => 'Seleciona times diferentes'], 404) ;
        }
        
        $partida_exits = Partida::where('time_id_casa', $request->time_id_casa)
        ->where('time_id_fora', $request->time_id_fora)
        ->where('torneio_id', $request->torneio_id)
        ->where('id','!=',$id)
        ->first();

        if($partida_exits) {
            return response()->json(['erro' => 'Não pode alterar as configurações de uma partida diferente da selecionada.'], 404) ;
        }
        
        $partida = $this->partidaRepository->update($id,$request->all());
        return response()->json($partida, 200);
    }

}