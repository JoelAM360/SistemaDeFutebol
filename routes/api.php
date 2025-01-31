<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\JogadorController;
use App\Http\Controllers\AdvogadoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\TorneioController;
use App\Http\Controllers\TorneioTimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
});

Route::post('user', [UserController::class, 'store']); // Rota pública
Route::get('teste', [UserController::class, 'teste']); // Rota pública
Route::post('recoveryPassword', [UserController::class, 'recoveryPassword']);

Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::apiResource('jogador', JogadorController::class);
    Route::apiResource('user', UserController::class)->except(['store']);
    Route::apiResource('advogado', AdvogadoController::class);
    Route::apiResource('categoria', CategoriaController::class);
    Route::apiResource('torneio', controller: TorneioController::class);
    Route::apiResource('time', TimeController::class);
    Route::apiResource('partida', PartidaController::class);
    Route::apiResource('torneiotimes', TorneioTimeController::class);
    

    /*Route::post('enviar_solitacao', [TorneioController::class, 'solicitacaoDoTime'])->name('solicitacaoDoTime');
    Route::patch('processarSolicitacaoDoTime', [TorneioController::class, 'processarSolicitacaoDoTime'])->name('processarSolicitacaoDoTime');*/
});



Route::post('/confirme_code', function (Request $request) {
    $codigo = Cache::get('codigo_aleatorio');

    if ($codigo == $request->code) {
        // Remover o código da cache
        Cache::forget('codigo_aleatorio');

        // Atualizar a confirmação de email
        $user = User::where('email', $request->email)->first();

        if ($user) {
        // Atualiza apenas se o email ainda não foi verificado
            if (!$user->email_verified_at) {
             $user->email_verified_at = now(); 
             $user->save(); // Salva a atualização no banco de dados
            }
        }

        return response()->json([
            'message' => 'Operação realizado com sucesso'
        ], 200); // Sucesso
    } else {
        return response()->json([
            'message' => 'Código não encontrado ou expirado.'
        ], 404); // Erro
    }
});