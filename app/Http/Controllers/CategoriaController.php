<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;
use App\Repositories\CategoriaRepository;
use App\Models\CategoriaTorneio;

class CategoriaController extends BaseController
{
    private CategoriaTorneio $categoria; 

    private CategoriaRepository $categoriaRepository;

    public function __construct(CategoriaTorneio $categoria) {
        $this->categoria = $categoria;
        $this->categoriaRepository = new CategoriaRepository($this->categoria);
        parent::__construct($this->categoriaRepository, 'torneios');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request)
    {
        $cat = $this->categoriaRepository->store($request->validated());
        return response()->json($cat, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(CategoriaRequest $request, $id)
    {
        $cat = $this->categoriaRepository->update($id,$request->validated());
        return response()->json($cat, 200);
    }
  
}