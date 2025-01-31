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
        parent::__construct($this->timeRepository, 'jogadores');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TimeRequest $request)
    {
        $time = $this->timeRepository->store($request->validated());
        return response()->json($time, 201);
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