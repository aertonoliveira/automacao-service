<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User as UserResource;
use App\Models\Role;
use App\Models\SaldoConta;
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

        $userAuth = Auth::user();

        $roleResult = Role::where('id', $userAuth->id)->first();
        $result = Role::where('name',$input['role_id'])->first();
        $input['role_id'] = $result->id;

        $user = User::create($input);

        DB::table('role_user')->insert([
            'user_id' =>  $user->id,
            'role_id' =>  $input['role_id']
        ]);

        $saldo['user_id'] = $user->id;
        $saldo['valor'] = 0;
        SaldoConta::create($saldo);


        if(config('url.account_verify')){
            // Email Verification
            $user->notify(new UserVerifyNotification( $input['email'], $input['password']));

            return response()->json(['data' => $user], 200);
        }

        return response()->json(['data' => $user], 200);

    }

    public function ativaCliente(Request $request)
    {
        $userAuth = Auth::user();
        $result = User::with('roles')->where('id', $userAuth->id)->get();

        if ($result[0]['roles'][0]['name'] === "Administrador"){
            $cliente = User::find($request->input('user_id'));

            if(!$cliente->ativo){
                $cliente->ativo = true;
                $cliente->save();
                return response()->json(['success' => "Ativado com sucesso!"], 201);

            }else{
                $cliente->ativo = false;
                $cliente->save();
                return response()->json(['success' => "Desativado com sucesso!"], 201);

            }



        }else{
            return response()->json(['error' => "Você não tem permissão para ativar"], 404);
        }


    }

    public function index(Request $request, $tipo){
        $roleResult = Role::where('name',$tipo)->first();
        $userResult = User::with('roles','parent','saldoConta')->where('role_id',$roleResult->id)->paginate(10);
        return response()->json($userResult, 200);
    }

    public function buscarPorParent(Request $request, $id){
        $userResult = User::with('roles','parent','saldoConta')->where('user_parent_id',$id)->paginate(10);
        return response()->json($userResult, 200);
    }

    public function obterCliente(Request $request, $id){
        $userResult = User::with('roles','parent','saldoConta','documentosClientes','contratoMutuo','contaBancaria.banco')->where('id',$id)->first();
        return response()->json($userResult, 200);
    }
}
