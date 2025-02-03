<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GolRequest extends FormRequest
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
    public function rules()
    {
        //Recuperando método de Request:
        $method =  $this->getMethod();

        //Recuperar o ID: 
        $regras = [
            'partida_id' => 'required|exists:partidas,id',
            'tempo' => 'required|numeric|min:0',
            'time_id' => 'required|exists:times,id',
            'jogador_id_marcador' => 'required|exists:jogadores,id',
            'jogador_id_assitente' => 'nullable|exists:jogadores,id',
            'tipo_de_gol' => 'required|in:normal,livre,penalte,gol_contra'
        ];

        $this->validaCaoDinamicaParaOMethodPacth($method, $regras);

        return $regras;
    }

    public function messages() 
    {
        return [   
            'required' => 'O campo :attributes é obrigatório',
            'partida_id.exists' => 'Está partida não está registrada',
            'tempo.numeric' => 'O tempo deve ser um número',
            'time_id.exists' => 'Este time não existe',
            'jogador_id_marcador.exists' => 'Este jogador não existe',
            'jogador_id_assitente.exists' => 'Este jogador não existe',
            'tipo_de_gol.in' => 'O tipo de gol deve ser:normal,livre,penalte,gol_contra'
        ];
    }
}