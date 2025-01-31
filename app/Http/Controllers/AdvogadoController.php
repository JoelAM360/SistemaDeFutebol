<?php

namespace App\Http\Controllers;

use App\Models\Advogado;
use App\Models\Jogador;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\AdvogadoRepository;
use App\Http\Requests\AdvogadoRequest;

class AdvogadoController extends Controller
{
    private Advogado $advogado;
    private AdvogadoRepository $advogadoRepo;

    public function __construct(Advogado $advogado) {
        $this->advogado = $advogado;
        $this->advogadoRepo = new AdvogadoRepository($this->advogado);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        //Selecionada os atributos da tabel relacionada:
        if ($request->has('atributos_user')) {
           $this->advogadoRepo->selectAtributosRelacionados("user:id,$request->atributos_user");
        } else {
           $this->advogadoRepo->selectAtributosRelacionados("user");
        }
        
        //Realizando filtros na consuta:
        if ($request->has('filtro')) {
           $this->advogadoRepo->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
           $this->advogadoRepo->selectAtributos($request->atributos);
        }
        
        return response()->json($this->advogadoRepo->getModel(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdvogadoRequest $request)
    {
        $advogado = $this->advogadoRepo->store($request->validated());
        return response()->json($advogado, 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
