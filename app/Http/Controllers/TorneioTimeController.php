<?php

namespace App\Http\Controllers;

use App\Services\TorneioTimeService;
use App\Models\TorneioTime;
use App\Http\Requests\TorneioTimeRequest;
use App\Repositories\TorneioTimeRepository;

class TorneioTimeController extends BaseController
{
    private TorneioTime $torneio;
    private TorneioTimeRepository $torneioRepository;

    protected $torneioService;

    public function __construct(TorneioTime $torneio) {
       $this->torneio = $torneio;
       $this->torneioRepository = new TorneioTimeRepository($this->torneio);
       $this->torneioService = new TorneioTimeService($this->torneio); 
       parent::__construct($this->torneioRepository, 'times');
    }
    
    public function store(TorneioTimeRequest $request) {

        $participante = TorneioTime::where('time_id',$request->time_id)
        ->where('torneio_id',$request->torneio_id)
        ->first();
        
        if($participante) {
            return response()->json(['erro' => 'Este time já está inscrito'], 404) ;
        }

        $participante =  $this->torneioRepository->store($request->all());

        return response()->json($participante, 201);
    }

    public function update(TorneioTimeRequest $request, $id) {
        $participante = TorneioTime::where('time_id',$request->time_id)
        ->where('torneio_id',$request->torneio_id)
        ->where('id','!=',$id)
        ->exists();

        if($participante) {
            return response()->json(['erro' => 'Não pode alterar as configurações de time'], 404) ;
        }
        
        $participante =  $this->torneioRepository->update($id,$request->all());

        return response()->json($participante, 200);
    }

    public function destroy($id)
    {
        $this->torneioService->removerTimeDoTorneio($id);
    }
    
}