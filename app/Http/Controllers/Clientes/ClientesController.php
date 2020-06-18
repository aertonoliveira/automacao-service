<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User as UserResource;
use App\Models\DocumentosClientes;
use App\Models\Role;
use App\Models\SaldoConta;
use App\Notifications\UserVerifyNotification;
use App\User;
use Carbon\Carbon;
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

    public function update(Request $request,$id){
        $input = $request->all();
        $user = User::find($id);
        $result = Role::where('name',$input['role_id'])->first();
        $input['role_id'] = $result->id;

        if (!$input["password"]) {
            $input["password"] = $user->password;
        } else {
            $input["password"] = bcrypt($input['password']);
        }



        $user->update($input);
        return response()->json(['success' => 'ok'], 200);
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
        $userAuth = Auth::user();
        $roleResult = Role::where('name',$tipo)->first();

        $result = User::with('roles')->where('id', $userAuth->id)->get();
        if ($result[0]['roles'][0]['name'] === "Administrador"){
            $userResult = User::with('roles','parent','saldoConta')->where('role_id',$roleResult->id)->paginate(10);
            return response()->json($userResult, 200);
        }else{
            $userResult = User::with('roles','parent','saldoConta')->where(['role_id'=>$roleResult->id, 'user_parent_id'=>  $userAuth->id ])->paginate(10);
            return response()->json($userResult, 200);
        }

    }

    public function buscarPorParent(Request $request, $id){
        $userAuth = Auth::user();
        $result = User::with('roles')->where('id', $userAuth->id)->get();
        if ($result[0]['roles'][0]['name'] === "Administrador"){
            $userResult = User::with('roles','parent','saldoConta')->where('user_parent_id',$id)->paginate(10);
            return response()->json($userResult, 200);
        }else{
            $userResult = User::with('roles','parent','saldoConta')->where('user_parent_id',$id)->paginate(10);
            return response()->json($userResult, 200);
        }

    }

    public function obterCliente(Request $request, $id){
        $userResult = User::with('roles','parent','saldoConta','documentosClientes','contratoMutuo','contaBancaria.banco')->where('id',$id)->first();
        return response()->json($userResult, 200);
    }

    public function getCliente(){
        $userAuth = Auth::user();
        $userResult = User::with('roles','parent','saldoConta','documentosClientes','contratoMutuo','contaBancaria.banco')->where('id',$userAuth->id)->first();
        return response()->json($userResult, 200);
    }

    public function getRelatorioClientes(){
        $resultUser['senior'] = User::where('role_id',4)->count();
        $resultUser['pleno'] = User::where('role_id',5)->count();
        $resultUser['clientes'] = User::where('role_id',6)->count();
        $resultUser['valor_total'] = DB::table("contrato_mutuos")->get()->sum("valor");

        return response()->json($resultUser, 200);
    }

    public function imagemCliente(Request $request){
        $userAuth = Auth::user();
        $date = Carbon::now();
        $name = uniqid(date('HisYmd'));

        $input = $request->all();

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $extension = $request->avatar->extension();
            $nameFile = "avatar.{$extension}";
            $request->avatar->storeAs('imagens/perfil/'. $userAuth->id . '/'  . $date->month . '/' . $date->day, $nameFile);
            $input['avatar'] = 'storage/imagens/perfil/'. $userAuth->id . '/'   . $date->month . '/' . $date->day . '/' . $nameFile;
        } else {
            return response()->json(['error' => 'Favor enviar somente imagens '], 409);
        }




        $resultCreate = User::updateOrCreate(['id' => $userAuth->id], $input);

        return response()->json($resultCreate, 200);
    }
}
