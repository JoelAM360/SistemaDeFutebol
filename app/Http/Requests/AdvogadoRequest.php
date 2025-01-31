<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvogadoRequest extends FormRequest
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
        //Recuperar o AdvogadoID:
        $advogadoId = $this->route('advogado');
        
        return [
            'user_id' => 'required|unique:advogados,user_id,'.$advogadoId,
            'numero_inscricao' => 'required|string|unique:advogados,numero_inscricao,'.$advogadoId.'|min:6|max:6'
        ];
    }

    public function messages(): array 
    {
        return [
            'user_id.required' => 'O campo user ID é obrigátorio',
            'user_id.unique' => 'O user ID já está sendo usado.',

            'numero_inscricao.required' => 'O campo número de inscrição da OA(Ordem do Advogados) é obrigatório',
            'numero_inscricao.unique' => 'O campo número de inscrição da OA(Ordem do Advogados) já está sendo usado',
            'numero_inscricao.min' => 'O campo número de inscrição da OA(Ordem do Advogados) deve ter no mínimo 6 caractres',
            'numero_inscricao.max' => 'O campo número de inscrição da OA(Ordem do Advogados) deve ter no máximo 6 caractres'
        ];
    }
}
