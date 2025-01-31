<?php

namespace App\Http\Controllers;

use App\Models\Torneio;
use App\Repositories\TorneioRepository;
use Illuminate\Http\Request;
use App\Http\Requests\TorneioRequest;

class TorneioController extends BaseController
{

    private Torneio $torneio;
    private TorneioRepository $torneioRepository;

    public function __construct(Torneio $torneio) {
       $this->torneio = $torneio;
       $this->torneioRepository = new TorneioRepository($this->torneio); 
       parent::__construct($this->torneioRepository, 'times');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(TorneioRequest $request)
    {
        $torneio = $this->torneioRepository->store($request->validated());
        return response()->json($torneio, 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function update(TorneioRequest $request, $id)
    {
        $torneio = $this->torneioRepository->update($id,$request->validated());
        return response()->json($torneio, 201);
    }
    
}