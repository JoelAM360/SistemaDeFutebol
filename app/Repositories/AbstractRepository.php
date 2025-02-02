<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AbstractRepository
{
    public $model;
    
    public function __construct(Model $model)
    {
       $this->model = $model; 
    }

    public function selectAtributosRelacionados($atributos) {
        $this->model = $this->model->with($atributos);
    }

    public function filtro($filtros)  {
        $filtros = explode(';',$filtros);

        foreach ($filtros as $key => $condicao) {
            $c = explode(':',$condicao );
           $this->model = $this->model->where($c[0], $c[1], $c[2]);
        }
    }

    public function selectAtributos($atributos) {
        $this->model = $this->model->selectRaw($atributos);
    }


    public function getModel() {
        return $this->model->get();
    }

    //Metodos CRUD:
    public function store(array $request) {
        return $this->model->create($request);
    }

    public function update($id ,array $request) 
    {
        $model = $this->model->find($id);
        
        if($model === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        } 

        $model->update($request);
        
        return response()->json($model, 200);
    }

    public function show($id) {
        $model = $this->model->find($id);
       
        if($model === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 
        
        return response()->json($model, 200);
    }

    public function delete($id) {
        $model = $this->model->find($id);

        if($model === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 

        return $model->delete();
    }

    public function find($id) {       
        return $this->model->find($id);
    }
}