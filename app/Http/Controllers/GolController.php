<?php

namespace App\Http\Controllers;

use App\Http\Requests\GolRequest;
use App\Models\Gol;
use App\Models\Jogador;
use App\Models\Time;
use App\Repositories\GolRepository;
use App\Repositories\JogadorRepository;
use App\Repositories\TimeRepository;
use App\Repositories\PartidaRepository;
use Illuminate\Http\Request;

class GolController extends BaseController
{
   
    private Gol $gol;
    private Jogador $jogador;
    private Time $times;
    private GolRepository $golRepository;
    private JogadorRepository $jogadorRepository;
    private TimeRepository $timeRepository;
    private PartidaRepository $partidaRepository;

    public function __construct(Gol $gol, JogadorRepository $jogadorRepository, PartidaRepository $partidaRepository)
    {
        $this->gol = $gol;
        $this->golRepository = new GolRepository($this->gol); 
        $this->jogadorRepository = $jogadorRepository; 
        $this->partidaRepository = $partidaRepository; 
        $this->timeRepository = new TimeRepository($this->gol); 

        parent::__construct($this->golRepository, 'partida');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GolRequest $request)
    {
        $dados = $request->validated();

        //Verficar se os time marcou está registrado neste partida:
        $times_exist = $this->partidaRepository->timesExists($dados);
      
        if($times_exist == null) {
            return response()->json(['erro' => 'Este time não está regitrado nesta partida'], 404) ;
        }
        
        //Validar se o jogador que fez gol percentence a dos times na partida:
        $jogador_exists_inTime = $this->jogadorRepository->findJogadorWithTimeById($dados['jogador_id_marcador'])->time;

        $jogador = $this->partidaRepository->jogadorBelongToTimeHomeOrOut($dados, $jogador_exists_inTime->id);

        if($jogador != null) {
            return response()->json(['erro' => 'Este jogador não percente a nenhum dos time que disputa a partida'], 404);
        }
        
        //Validar se jogador que fez a assistencia pertence ao time q marcou:


        //Salvar o registro de gols por cada time:
        $this->golRepository->store($request->validated());

        //Atualizar a quantidade de gols de partida para cada time:
        $gol_do_time = $this->golRepository->model
                                          ->where('time_id', $dados['time_id'])
                                          ->where('partida_id', $dados['partida_id'])
                                          ->get();
                                          
        $partida = $this->partidaRepository->find($dados['partida_id']);
        $total_de_gols = count($gol_do_time);
        
        //Verficar se o time é de casa ou fora:
        if($this->partidaRepository->timesDeCasa($dados)) {
            $partida->update(["gol_casa" => $total_de_gols]);
            
        } else {
            $partida->update(["gol_fora" => $total_de_gols]);
        }
        
        return response()->json($dados, 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(GolRequest $request, $id)
    {
        //
    }
}