<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User as UserResource;
use App\Notifications\UserVerifyNotification;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ClientesController extends Controller
{
    public function create(Request $request)
    {
        $userAuth = Auth::user();
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_parent_id'] = $userAuth->id;
        $user = User::create($input);

        DB::table('role_user')->insert([
            'user_id' =>  $user->id,
            'role_id' =>  $input['role_id']
        ]);
        //  Generate token
        $token = auth()->fromUser($user);

        // Transform user data
        $data = new UserResource($user);

        $test = config('url.account_verify');

        // Validate if user needs to verify their account
        if(config('url.account_verify')){
            // Email Verification
            $user->notify(new UserVerifyNotification($token));

            return response()->json(compact('data'));
        }

        return response()->json(compact('token', 'data', 'test'));

    }

    public function ativaCliente(Request $request)
    {
        $userAuth = Auth::user();
        $result = User::with('roles')->where('id', $userAuth->id)->get();

        if ($result[0]['roles'][0]['name'] === "Administrador"){

            if (!(new BcryptHasher)->check($request->input('password'), $userAuth->password)) {
                // Return Error message if password is incorrect
                return response()->json(['error' => 'E-mail ou senha está incorreto. A autenticação falhou.'], 401);
            }

            $cliente = User::find($request->input('user_id'));
            $cliente->ativo = true;
            $cliente->save();

            return response()->json(['success' => "Ativado com sucesso!"], 201);
        }else{
            return response()->json(['error' => "Você não tem permissão para ativar"], 401);
        }


    }
}
