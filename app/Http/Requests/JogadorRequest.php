<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JogadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $method = $this->getMethod();
        
        // Recuperando o ID da rota
        $jogadorId = $this->route('jogador');  

        //Array com as regras de validação: 
        $regras = [
            'nome'       => 'required|string|max:255',
            'time_id'    => 'required|exists:times,id',
            'advogado_id'    => 'required|exists:advogados,id|unique:jogadores,advogado_id,'.$jogadorId ,
            'posicao'    => 'required|string|in:goleiro,defensor,meio-campo,atacante',
            'img_perfil' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            //'idade'      => 'required|integer|min:16|max:45',
            'isCapitao' => 'required|in:nao,sim',
            'dorsal' => 'required|integer|unique:jogadores,dorsal,NULL,id,time_id,' . $this->time_id,
        ];
        
        // Condicional para verificar se o método é PUT , PATCH OU POST
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
        return $regras;
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo "nome" é obrigatório.',
            'nome.string' => 'O campo "nome" deve ser um texto.',
            'nome.max' => 'O campo "nome" não pode ter mais que 255 caracteres.',
    
            'time_id.required' => 'O campo "time_id" é obrigatório.',
            'time_id.exists' => 'O "time_id" fornecido não existe na tabela de times.',
    
            'posicao.required' => 'O campo "posição" é obrigatório.',
            'posicao.string' => 'O campo "posição" deve ser um texto.',
            'posicao.in' => 'O campo "posição" deve ser um dos seguintes valores: goleiro, defensor, meio-campo ou atacante.',

            'isCapitao.required' => 'O campo "isCapitao" é obrigatório.',
            'isCapitao.in' => 'O campo "isCapitao" deve ser "nao" ou "sim".',
    
           /*'idade.required' => 'O campo "idade" é obrigatório.',
            'idade.integer' => 'O campo "idade" deve ser um número inteiro.',
            'idade.min' => 'A "idade" mínima permitida é 16 anos.',
            'idade.max' => 'A "idade" máxima permitida é 45 anos.',*/
    
            'dorsal.required' => 'O campo "número da camisa" é obrigatório.',
            'dorsal.integer' => 'O campo "número da camisa" deve ser um número inteiro.',
            'dorsal.unique' => 'O "número da camisa" já está em uso por outro jogador neste time.',

            'advogado_id.required' => 'O campo "advogado_id" é obrigatório.',
            'advogado_id.exists' => 'O "advogado_id" fornecido não existe na tabela de times.',
            'advogado_id.unique' => 'O "advogado_id" já está associado a outro jogador.',

            'img_perfil.file' => 'O campo "img_perfil" deve ser um arquivo válido.',
            'img_perfil.mimes' => 'O campo "img_perfil" deve ser um arquivo do tipo: jpeg, png, jpg ou gif.',
            'img_perfil.max' => 'O arquivo "img_perfil" não pode ser maior que 2 MB.',
        ];
    }
    
}
