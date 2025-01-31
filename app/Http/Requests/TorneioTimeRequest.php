<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TorneioTimeRequest extends FormRequest
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

        $regras = [
            'torneio_id' => "required|exists:torneios,id",
            'time_id' => "required|exists:times,id",
            'status' => 'required|in:pendente,aprovado,reprovado',
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
            'exists' => 'O campo :attributes não existe',
            'status.in' => 'O campo status deve pendente, aprovado ou reprovado',
        ];
    }
}