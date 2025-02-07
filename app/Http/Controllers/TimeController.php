<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeRequest;
use App\Models\Time;
use App\Repositories\TimeRepository;
use Illuminate\Http\Request;

class TimeController extends BaseController
{

    private Time $time;
    private TimeRepository $timeRepository;

    public function __construct(Time $time)
    {
        $this->time = $time;
        $this->timeRepository = new TimeRepository($this->time); 
        parent::__construct($this->timeRepository, 'categoria');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TimeRequest $request)
    {
        $time = $this->timeRepository->store($request->validated());
        return response()->json($time, 201);
    }
    public function show($id)
    {
        if($this->timeRepository->find($id) === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 
        
        //Selecionada os atributos da tabel relacionada:
        $this->getValuesByFilter();
        $this->timeRepository->model->with(['torneios', 'torneios_times']);
        
        $data = $this->repository->show($id);

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(TimeRequest $request, $id)
    {
        $time = $this->timeRepository->update($id,$request->validated());
        return response()->json($time, 200);
    }
}