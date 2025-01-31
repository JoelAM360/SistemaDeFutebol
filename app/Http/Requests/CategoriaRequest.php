<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
        //Recuperar o ID da rota:
        $categoriaId = $this->route('categorium');
        return [
            "titulo_categoria"=> "required|unique:categorias_torneios,titulo_categoria,".$categoriaId."|max:20|min:6",
        ];
    }

    public function messages(): array
    {
        return [
            'titulo_categoria.required' => "O campo título da categoria é obrigatório",
            'titulo_categoria.unique' => "Este título da categoria já está sendo usado",
            'titulo_categoria.max' => "O título da categoria deve ter no máximo 20 caractres",
            'titulo_categoria.min' => "O título da categoria deve ter no mínimo 6 caractres",
        ];
    }
}
