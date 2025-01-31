<?php

namespace App\Http\Controllers;

use App\Models\Advogado;
use App\Models\Jogador;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\AdvogadoRepository;

class UserController extends Controller
{   
    private User $user;
    private UserRepository $userRepo;

    public function __construct(User $user) {
        $this->user = $user;
        $this->userRepo =  new UserRepository($this->user);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Selecionada os atributos da tabel relacionada:
        if ($request->has('atributos_advogados')) {
            $atributos_advogados =  $request->atributos_advogados;

            $this->userRepo->selectAtributosRelacionados("advogado:id,$atributos_advogados");
        } else {
            $this->userRepo->selectAtributosRelacionados("advogado");
        }
        
        //Realizando filtros na consuta:
        if ($request->has('filtro')) {
            $this->userRepo->filtro($request->filtro);
        }


        if ($request->has('atributos')) {
            $this->userRepo->selectAtributos($request->atributos);
        }
        
        return response()->json($this->userRepo->getModel(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // Criar o usuário com hash na senha
        $userRequest = [
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tipo_de_user' => $request->tipo_de_user ?? 'admin',
        ];

        $user = $this->userRepo->store($userRequest);
    
        // Gerar token JWT
        $token = @auth('api')->login($user);

        $this->recoveryPasswordDefault($userRequest['email'], 'Seu código de confirmação de email é:');
    
        // Retornar resposta JSON
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function recoveryPassword() 
    {
        // Atualizar a confirmação de email
        $user = User::where('email', request('email'))->first();
    
        if ($user) {
            $this->recoveryPasswordDefault(request('email'));
        }

        return response()->json([
            'message' => 'Verificar o código confirmar no seu email'
        ], 200); // Sucesso
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->user->find($id);
        if($user === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        } 

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $user=$this->userRepo->update($id,$request->all());

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        
        if($user === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        } 
 
        $user->delete();

        return response()->json(['message' => 'Conta excluida com sucesso'], 200);
    }
}
