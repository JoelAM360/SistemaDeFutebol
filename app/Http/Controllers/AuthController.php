<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class AuthController extends Controller
{

     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'forgotPassword', 'resetPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6'
    ], [
        'email.required' => 'O campo e-mail é obrigatório.',
        'email.email' => 'Insira um e-mail válido.',
        'password.required' => 'O campo senha é obrigatório.',
        'password.min' => 'A senha deve ter pelo menos 6 caracteres.'
    ]);

    $credentials = $request->only('email', 'password');

          
    $token = auth('api')->attempt($credentials);
    // Gerar token JWT

    if (!$token) {
        return response()->json(['error' => 'Email e/ou senha inválidos'], 401);
    }

    return $this->respondWithToken($token);
}


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
       return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
            return response()->json([
                'message' => 'Login realizado com sucesso!',
                'user' => auth()->user(),
                'token' => $token
             ]);
    }

public function forgotPassword(Request $request)
{
    $request->validate(['email' => 'required|email|exists:users,email']);

    $status = Password::sendResetLink($request->only('email'));

  
    return $status === Password::RESET_LINK_SENT
        ? response()->json(['message' => 'Link de recuperação enviado para o seu e-mail.'])
        : response()->json(['message' => 'Erro ao enviar o link.'], 400);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'token' => 'required',
        'password' => 'required|min:6|confirmed'
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['message' => 'Senha redefinida com sucesso!'])
        : response()->json(['message' => 'Token inválido ou expirado.'], 400);
}
}