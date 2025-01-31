<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    
    public function recoveryPasswordDefault($requestEmail, $msg = 'Seu código de recuperação de senha é: ') {
            // Passo 1: Gerar código aleatório de 5 caracteres
            $codigo = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        
            // Passo 2: Armazenar na cache por 10 minutos (600 segundos)
            Cache::put('codigo_aleatorio', $codigo, 600);
        
            Mail::raw($msg . $codigo, function ($message) use($requestEmail) {
                 $message->to($requestEmail)
                 ->subject('Teste de E-mail Laravel');
            });
    }

    public function teste($teste) {
        return ['teste' => $teste];
    }
}
