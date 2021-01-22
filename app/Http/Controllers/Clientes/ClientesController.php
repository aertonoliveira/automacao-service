<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Clientes\StoreCLienteRequest;
use App\Http\Resources\User as UserResource;
use App\Models\Arquivo;
use App\Models\ContratoMutuo;
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
use Illuminate\Support\Facades\Storage;


class ClientesController extends Controller
{

    private $repository;

    public function __construct(User $user)
    {
        $this->repository = $user;
    }

    public function create(StoreCLienteRequest $request)
    {
        try {
            $userAuth = Auth::user();
            $user = new User();
            $input = $request->all();

            $user->password = bcrypt($request->password);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->user_parent_id = $userAuth->id;
            $user->rg = $request->rg;
            $user->data_emissao = $request->data_emissao;
            $user->orgao_emissor = $request->orgao_emissor;
            $user->cpf = $request->cpf;
            $user->data_nascimento = $request->data_nascimento;
            $user->estado_civil = $request->estado_civil;
            $user->nome_mae = $request->nome_mae;
            $user->genero = $request->genero;
            $user->rua = $request->rua;
            $user->numero = $request->numero;
            $user->bairro = $request->bairro;
            $user->cidade = $request->cidade;
            $user->estado = $request->estado;
            $user->complemento = $request->complemento;
            $user->cep = $request->cep;
            $user->telefone = $request->telefone;
            $user->celular = $request->celular;
            $user->role_id = $request->role_id;

            $user->save();

            DB::table('role_user')->insert([
                'user_id' =>  $user->id,
                'role_id' =>  $input['role_id']
            ]);
            $saldo['user_id'] = $user->id;
            $saldo['valor'] = 0;
            SaldoConta::create($saldo);
            $user->notify(new UserVerifyNotification( $input['email'], $input['password']));

            return [
                'status_code' => 200,
                'data' => $user
            ];
        } catch (\Exception $error) {
            return [
                'status_code' => 400,
                'message' => $error->getMessage()
            ];
        }








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
        //dd($roleResult);
        $result = User::with('roles')->where('id', $userAuth->id)->get();
        if ($result[0]['roles'][0]['name'] === "Administrador" || $result[0]['roles'][0]['name'] === "Diretor"){
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

        $from = date('2020-12-01');
        $to = date('2020-12-31');
        $simples = ContratoMutuo::where('tipo_contrato','Simples')->pluck('id');
        $composto = ContratoMutuo::where('tipo_contrato','Composto')->pluck('id');
        $resultUser['valor_total_simples'] = \App\Models\RelatorioMensal::whereIn('contrato_id',$simples)->whereBetween('data_referencia', [$from, $to])->sum('comissao');
        $resultUser['valor_total_composto'] = \App\Models\RelatorioMensal::whereIn('contrato_id',$composto)->whereBetween('data_referencia', [$from, $to])->sum('comissao');


        $resultUser['senior'] = User::where('role_id',4)->count();
        $resultUser['pleno'] = User::where('role_id',5)->count();
        $resultUser['parceiros'] = User::where('role_id',7)->count();
        $resultUser['clientes'] = User::where('role_id',6)->count();
        $resultUser['valor_total'] = DB::table("contrato_mutuos")->where('ativo',true)->get()->sum("valor");

        return response()->json($resultUser, 200);
    }

    public function imagemCliente(Request $request){
        $userAuth = Auth::user();
        $date = Carbon::now();
        $name = uniqid(date('HisYmd'));

        $input = $request->all();

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $url = Storage::disk('s3')->put('images/avatar/'.$userAuth->id, $request->file('avatar'),[ 'visibility' => 'public',]);
            $input['avatar'] =$url;
        } else {
            return response()->json(['error' => 'Favor enviar somente imagens '], 409);
        }




        $resultCreate = User::updateOrCreate(['id' => $userAuth->id], $input);

        return response()->json($resultCreate, 200);
    }
}
