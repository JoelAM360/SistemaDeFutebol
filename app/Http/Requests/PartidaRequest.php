<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartidaRequest extends FormRequest
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
        //Recuperando método de Request:
        $method =  $this->getMethod();

        //Recuperar o ID: 
        $regras = [
            'categoria_id' => "required|exists:categorias_torneios,id",
            'torneio_id' => "required|exists:torneios,id",
            'time_id_casa' => "required|exists:times,id|exists:torneios_times,time_id",
            'time_id_fora' => "required|exists:times,id|exists:torneios_times,time_id",
            'resultado' => "nullable|string|in:casa,fora,empate",
            'local' => "required|string",
            'gol_casa' => "nullable|numeric",
            'gol_fora' => "nullable|numeric",
            'data_marcada' => "required|date",
            'status' => "required|in:pendente,jogando,terminada,intervalo",
        ];

        $this->validaCaoDinamicaParaOMethodPacth($method, $regras);

        return $regras;
    }

    public function messages() {
        return [
            'required' => "O campo :attributes é obrigatório",
            'exists' => "O :attributes não existe",
            'time_id_casa.exists' => "Este time não está inscrito no torneio (Verfica o parâmetro: time_id_casa)",
            'time_id_fora.exists' => "Este time não está inscrito no torneio (Verfica o parâmetro: time_id_fora)",
            'resultado.in' => "O campo resultado suporta o valores:'casa' - vitória time de casa,'fora'-vitória para o time de fora e 'empate'",
            'string' => "O campo :attributes deve ser um texto",
            'numeric' => "O campo :attributes deve ser um número",
            'date' => "O campo :attributes deve ser uma de data com a hora",
            'status.in' => "O status só permite: pendente,jogando,terminada,intervalo",
        ];
    }
}