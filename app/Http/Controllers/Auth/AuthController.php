<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

use Illuminate\Hashing\BcryptHasher;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        // Get User by email
        $user = User::where('email', $request->email)->first();

        // Return error message if user not found.
        if(!$user) return response()->json(['error' => 'Usuário não encontrado.'], 404);

        // Account Validation
        if (!(new BcryptHasher)->check($request->input('password'), $user->password)) {
            // Return Error message if password is incorrect
            return response()->json(['error' => 'E-mail ou senha está incorreto. A autenticação falhou.'], 401);
        }

        // Account verification validation
        if(!$user->ativo) return response()->json(['error' => 'Favor aguardar sua ativação'], 401);


        // Get email and password from Request
        $credentials = $request->only('email', 'password');

        try {
            // Login Attempt
            if (! $token = auth()->attempt($credentials)) {
                // Return error message if validation failed
                return response()->json(['error' => 'invalid_credentials'], 401);

            }
        } catch (JWTException $e) {
            // Return Error message if cannot create token.
            return response()->json(['error' => 'could_not_create_token'], 500);

        }

        // transform user data
        $data = User::with('roles','parent')->where('id', $user->id)->first();
        $result = User::with('roles.permission')->where('id', $user->id)->get();
//        dd($result[0]['roles']);

        $permissao = [];
        if(count($result[0]['roles']) > 0){
            $permissao = $result[0]['roles'][0]['permission'];
        }

        return response()->json(compact('token', 'data','permissao'));


    }
}
