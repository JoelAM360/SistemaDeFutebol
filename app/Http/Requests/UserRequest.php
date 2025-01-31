<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        // Recuperar o método HTTP (PUT, PATCH, etc.)
        $method = $this->getMethod();
        
        // Recuperando o ID da rota
        $userId = $this->route('user');  

        //Array com as regras de validação: 
        $regras = [
            "nome" => 'required|string|max:255',
            "email" => 'required|email|unique:users,email,' . $userId . '|max:255',
            "password" => 'required|string|min:6|max:8',
            "tipo_de_user" => 'required|string|in:admin,advogado,adepto',
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

        //Se for POST OU PUT:
        return $regras;
    }
    
    
    public function messages(): array
    {
        return [
            // Mensagens para o campo "nome"
            "nome.required" => "O campo nome é obrigatório.",
            "nome.string" => "O nome deve ser um texto.",
            "nome.max" => "O nome não pode ter mais que 255 caracteres.",
            
            // Mensagens para o campo "email"
            "email.required" => "O campo email é obrigatório.",
            "email.email" => "Por favor, insira um endereço de email válido.",
            "email.max" => "O email não pode ter mais que 255 caracteres.",
            "email.unique" => "O email já está sendo usado.",
    
            // Mensagens para o campo "password"
            "password.required" => "O campo senha é obrigatório.",
            "password.string" => "A senha deve ser uma string.",
            "password.min" => "A senha deve ter no mínimo 6 caracteres.",
            "password.max" => "A senha não pode ter mais que 8 caracteres.",
    
            // Mensagens para o campo "tipo_de_user"
            "tipo_de_user.required" => "O tipo de usuário é obrigatório.",
            "tipo_de_user.string" => "O tipo de usuário deve ser um texto.",
            "tipo_de_user.in" => "O tipo de usuário deve ser um dos seguintes: admin, advogado ou adepto.",
        ];
    }
    
}
