<?php

namespace App\Http\Controllers;

use App\Http\Requests\GolRequest;
use App\Models\Gol;
use App\Repositories\GolRepository;
use App\Repositories\JogadorRepository;
use App\Repositories\PartidaRepository;

class GolController extends BaseController
{
   
    private Gol $gol;
    private GolRepository $golRepository;
    private JogadorRepository $jogadorRepository;
    private PartidaRepository $partidaRepository;

    public function __construct(Gol $gol, JogadorRepository $jogadorRepository, PartidaRepository $partidaRepository)
    {
        $this->gol = $gol;
        $this->golRepository = new GolRepository($this->gol); 
        $this->jogadorRepository = $jogadorRepository; 
        $this->partidaRepository = $partidaRepository; 

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
        
        //Validar se o jogador que fez o gol pertence a dos times na partida:
        $jogador_exists_inTime = $this->jogadorRepository->findJogadorWithTimeById($dados['jogador_id_marcador'])->time;

        $jogador = $this->partidaRepository->jogadorBelongToTimeHomeOrOut($dados, $jogador_exists_inTime->id);
  
        if($jogador == null) {
            return response()->json(['erro' => 'Este jogador não percente a nenhum dos time que disputa a partida'], 404);
        }
        
        //Validar se jogador que fez a assistencia pertence ao time q marcou:
        if(isset($dados['jogador_id_assitente'])) {
            $jogador_ass_exists_inTime = $this->jogadorRepository->findJogadorWithTimeById($dados['jogador_id_assitente'])->time;

            $jogador_ass = $this->partidaRepository->jogadorBelongToTimeHomeOrOut($dados, $jogador_ass_exists_inTime->id);

            if($jogador_ass != null) {
                return response()->json(['erro' => 'Este jogador que fez a assistência não percente a nenhum dos time que disputa a partida'], 404);
            }
        }
        

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

    public function destroy($id) 
    {
        $gol =  $this->golRepository->find($id);
        
        if( $gol == null) {
            return response()->json(['error' => "Recurso pesquisado não existe"], 404);
        }

        //Atualizar a quantidade de gols de partida para cada time:
        $gol_do_time = $this->golRepository->model
                                          ->where('time_id', $gol['time_id'])
                                          ->where('partida_id', $gol['partida_id'])
                                          ->get();
                                          
        $partida = $this->partidaRepository->find($gol['partida_id']);
        $total_de_gols = count($gol_do_time)  - 1;

        
        //Verficar se o time é de casa ou fora:
        if($this->partidaRepository->timesDeCasa($gol)) {
            $partida->update(["gol_casa" => $total_de_gols]);
            
        } else {
            $partida->update(["gol_fora" => $total_de_gols]);
        }

        $gol->delete();

        return response()->json(['message' => "Gol apagado com sucesso"], 200);
    }
}