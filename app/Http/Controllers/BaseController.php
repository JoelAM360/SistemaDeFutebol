<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $repository;
    protected $model;
    public function __construct($repository, $model=null)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {     
        $this->getValuesByFilter();
        return response()->json($this->repository->getModel(), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if($this->repository->find($id) === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 
        
        //Selecionada os atributos da tabel relacionada:
        $this->getValuesByFilter();
        $data = $this->repository->show($id);

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Recurso apagado com sucesso'], 200);
    }

    public function getValuesByFilter() {
        //Realizando filtros na consuta:
        if (request()->has('filtro')) {
            $this->repository->filtro(request('filtro'));
        }

        if (request()->has('atributos')) {
            $this->repository->selectAtributos(request('atributos'));
        }

        //Selecionada os atributos da tabel relacionada:
        if (request()->has('atributos_'.$this->model)) {
            $request_atributos_rel= request('atributos_'.$this->model);
            #dd("$this->model:id, $request_atributos_rel");
            $this->repository->selectAtributosRelacionados(["$this->model:id,$request_atributos_rel"]);
        } else {
           #dd($this->model);
            $this->repository->selectAtributosRelacionados($this->model);
        }
    }
}