<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartidaRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer essa solicitação.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Define se o usuário está autorizado a realizar a ação
    }

    /**
     * Define as regras de validação.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categoria_id'    => 'required|exists:categorias_torneios,id',
            'torneio_id'      => 'required|exists:torneios,id',
            'time_id_casa'    => 'required|exists:times,id',
            'time_id_fora'    => 'required|exists:times,id|different:time_id_casa',
            'resultado'       => 'nullable|in:casa,fora',
            'local'           => 'required|string|max:255',
            'gol_casa'        => 'nullable|integer|min:0',
            'gol_fora'        => 'nullable|integer|min:0',
            'data_marcada'    => 'required|date',
            'status'          => 'required|in:pendente,jogando,terminada',
        ];
    }

    /**
     * Define as mensagens de erro personalizadas.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'categoria_id.required'  => 'O campo categoria é obrigatório.',
            'categoria_id.exists'    => 'A categoria informada não existe.',
            'torneio_id.required'    => 'O campo torneio é obrigatório.',
            'torneio_id.exists'      => 'O torneio informado não existe.',
            'time_id_casa.required'  => 'O time da casa é obrigatório.',
            'time_id_fora.required'  => 'O time visitante é obrigatório.',
            'time_id_fora.different' => 'Os times da casa e visitante não podem ser iguais.',
            'gol_casa.integer'       => 'O número de gols da casa deve ser um número inteiro.',
            'gol_fora.integer'       => 'O número de gols do time visitante deve ser um número inteiro.',
            'data_marcada.required'  => 'A data da partida é obrigatória.',
            'data_marcada.date'      => 'A data fornecida não é válida.',
            'status.required'        => 'O status da partida é obrigatório.',
            'status.in'              => 'O status deve ser um dos seguintes: pendente, jogando, terminada.',
        ];
    }
}
