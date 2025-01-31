<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TorneioRequest extends FormRequest
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
        //Recuperar o method:
        $method =  $this->getMethod();

        //Recuperar o ID da rota:
        $torneioId= $this->route('torneio');
        #dd($method );
        $regras = [
            'categoria_id' => 'required|exists:categorias_torneios,id',
            'nome' =>'required|unique:torneios,nome,'.$torneioId,
            'jornadas' => 'required|numeric',
            'quantidade_times' => 'required|numeric',
            'img_icon' => 'required|file|mimes:png,jpg,jpeg|max:2048',
            'data_inicio' => 'required|date',
            'data_termino' => 'required|date',
            'status' => 'required|in:ativo,desativo',
        ];

        if ($method == 'PATCH') {
            $regrasDinamicas = [];

            // Definir as regras de validação para PATCH
            foreach ($regras as $input => $regra) {
                if (array_key_exists($input, $this->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            return $regrasDinamicas;
        }

        //POST ou PUT
        return  $regras;
    }

    public function messages(): array
    {
        return [
            'required' =>'O campo :attributes é obrigatório',
            'categoria_id.exists' => 'Está categoria não existe',
            'numeric' => 'O campo :attibutes deve ser um número',
            'date' => 'O campo :attrinutes deve ser um data',
            'status.in' => 'O campo status deve Ativo ou Inativo',
            'img_icon.file' => 'O Imagem de Icon deve ser um arquivo(jpg,png,jpge)',
            'img_icon.mimes' => 'O Imagem de Icon deve ser um arquivo do tipo jpg,png,jpge',
            'img_icon.max' => 'O arquivo da Imagem de Icon  deve ter 2MB no máximo',
        ];
    }
}
