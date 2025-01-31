<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //Recuperar o method da requisição:
        $method = $this->getMethod();

        //Recuperar ID da Rota:
        $timesId = $this->route('time');
    
        $regras = [
            'nome' => 'required|min:6|max:45',
            'categoria_id' => 'required|exists:categorias_torneios,id',
            'advogado_id' => 'required|unique:times,advogado_id,'.$timesId.'|exists:advogados,id',
            'img_escudo' => 'required|file|mimes:png,jpg,jpeg|max:2048',
            'status' => 'required|in:ativo,desativo,pendente'
        ];

        $this->validaCaoDinamicaParaOMethodPacth($method, $regras);

        return $regras;
    }

    public function messages() {
        return [
            'required'=> 'O campo :attributes é obrigatório',
            'categoria_id.required'=> 'O campo categoria é obrigatório',
            'advogado_id.required'=> 'Você precisa criar um perfil de advogado (obrigatório)',
            'categoria_id.exists' => 'A categoria selecionada não existe',
            'advogado_id.exists' => 'Você precisa criar um perfil de advogado (obrigatório). Informações inválidas',
            'advogado_id'=> 'Você não cadstrar mais de um time',
            'img_escudo.file' => 'O campo Imagem do Escudo deve ser um arquivo(png,jpg,jpeg)',
            'img_escudo.mimes' => 'O campo Imagem do Escudo deve ser um arquivo do tipo:png,jpg ou jpeg',
            'nome.max' => "O nome do time deve ter no máximo 45 caractres",
            'nome.min' => "O nome do time deve ter no mínimo 6 caractres",
        ];
    }
}