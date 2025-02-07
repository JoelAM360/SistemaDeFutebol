<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Repositories\PartidaRepository;
use Illuminate\Http\Request;
use App\Http\Requests\PartidaRequest;
use App\Repositories\ClassificacaoRepository;

class PartidaController extends BaseController
{
    private Partida $partida;
    private PartidaRepository $partidaRepository;
    private ClassificacaoRepository $classificacaoRepository;
    

    public function __construct(partida $partida, ClassificacaoRepository $classificacaoRepository)
    {
        $this->partida = $partida;
        $this->partidaRepository = new partidaRepository($this->partida); 
        $this->classificacaoRepository = $classificacaoRepository; 
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
        if ($request->time_id_fora == $request->time_id_casa) {
            return response()->json(['erro' => 'Selecione times diferentes'], 404);
        }

        $partida_exists = Partida::where('time_id_casa', $request->time_id_casa)
            ->where('time_id_fora', $request->time_id_fora)
            ->where('torneio_id', $request->torneio_id)
            ->where('id', '!=', $id)
            ->first();

        if ($partida_exists) {
            return response()->json(['erro' => 'Não pode alterar as configurações de uma partida diferente da selecionada.'], 404);
        }

        // Atualiza a partida
        $partida = $this->partidaRepository->find($id);
        //$request->all()
        
        if ($request->status == 'terminada') {
            // Determinar o resultado da partida
            if ($partida->gol_casa > $partida->gol_fora) {
                $resultado = 'casa'; // Vitória do time da casa
            } elseif ($partida->gol_casa < $partida->gol_fora) {
                $resultado = 'fora'; // Vitória do time de fora
            } else {
                $resultado = 'empate'; // Empate
            }

            // Atualizar o resultado da partida
            $partida->update(['resultado' => $resultado, 'status' => $request->status]);

            // Dados do time em casa
            $dadosCasa = [
                'torneio_id' => $request->torneio_id,
                'time_id' => $request->time_id_casa,
                'vitorias' => Partida::where('time_id_casa', $request->time_id_casa)
                    ->where('torneio_id', $request->torneio_id)
                    ->where('resultado', 'casa')
                    ->count(),
                'derrotas' => Partida::where('time_id_casa', $request->time_id_casa)
                    ->where('torneio_id', $request->torneio_id)
                    ->where('resultado', 'fora')
                    ->count(),
                'empates' => Partida::where('time_id_casa', $request->time_id_casa)
                    ->where('torneio_id', $request->torneio_id)
                    ->where('resultado', 'empate')
                    ->count(),
                'gol_marcados' => Partida::where('time_id_casa', $request->time_id_casa)
                    ->where('torneio_id', $request->torneio_id)
                    ->sum('gol_casa'),
                'gol_sofridos' => Partida::where('time_id_casa', $request->time_id_casa)
                    ->where('torneio_id', $request->torneio_id)
                    ->sum('gol_fora'),
                'gol_diferenca' => Partida::where('time_id_casa', $request->time_id_casa)
                    ->where('torneio_id', $request->torneio_id)
                    ->sum('gol_casa') - Partida::where('time_id_casa', $request->time_id_casa)
                    ->where('torneio_id', $request->torneio_id)
                    ->sum('gol_fora'),
            ];

            // Dados do time fora de casa
            $dadosFora = [
                'torneio_id' => $request->torneio_id,
                'time_id' => $request->time_id_fora,
                'vitorias' => Partida::where('time_id_fora', $request->time_id_fora)
                    ->where('torneio_id', $request->torneio_id)
                    ->where('resultado', 'fora')
                    ->count(),
                'derrotas' => Partida::where('time_id_fora', $request->time_id_fora)
                    ->where('torneio_id', $request->torneio_id)
                    ->where('resultado', 'casa')
                    ->count(),
                'empates' => Partida::where('time_id_fora', $request->time_id_fora)
                    ->where('torneio_id', $request->torneio_id)
                    ->where('resultado', 'empate')
                    ->count(),
                'gol_marcados' => Partida::where('time_id_fora', $request->time_id_fora)
                    ->where('torneio_id', $request->torneio_id)
                    ->sum('gol_fora'),
                'gol_sofridos' => Partida::where('time_id_fora', $request->time_id_fora)
                    ->where('torneio_id', $request->torneio_id)
                    ->sum('gol_casa'),
                'gol_diferenca' => Partida::where('time_id_fora', $request->time_id_fora)
                    ->where('torneio_id', $request->torneio_id)
                    ->sum('gol_fora') - Partida::where('time_id_fora', $request->time_id_fora)
                    ->where('torneio_id', $request->torneio_id)
                    ->sum('gol_casa'),
            ];
        }

        $this->classificacaoRepository->store($dadosCasa);
        $this->classificacaoRepository->store($dadosFora);
        
        return response()->json([
            'partida' => $partida,
            'resultado' => $resultado ?? null,
            'casa' => $dadosCasa ?? null,
            'fora' => $dadosFora ?? null,
        ], 200);
    }


}