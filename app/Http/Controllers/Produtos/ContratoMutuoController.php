<?php

namespace App\Http\Controllers\Produtos;

use App\Utils\Helper;
use App\Models\ContratoMutuo;
use App\Models\Role;
use App\Models\SaldoConta;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ContratoMutuoController extends Controller
{
    private $repository;

    public function __construct(ContratoMutuo $contrato)
    {
        $this->repository = $contrato;
    }

    public function create(Request $request)
    {

        $userAuth = Auth::user();

        $roleResult = Role::where('id', $userAuth->role_id)->first();
        $input = $request->all();

        $datetime = Carbon::now('America/Sao_Paulo');
        $input['inicio_mes'] = $datetime->format('Y-m-d H:i:s');
        $input['final_mes'] = date("Y-m-d H:i:s", strtotime($input['tempo_contrato'] . ' month'));




        if ($roleResult->name == 'Administrador' || $roleResult->name == 'Diretoria' ) {
            $resultCreate                      = ContratoMutuo::create($input);
            $resultCreate['numero_contrato']   = str_pad($resultCreate->id.$datetime->format('m').$datetime->format('d'), 6, 0, STR_PAD_RIGHT);
            $resultCreate['valor_atualizado']  = $input['valor'];
            $resultCreate->save();
        } else {
            $input['porcentagem']             = $this->calculaComissao($input['valor'], $input['porcentagem']);
            $resultCreate                     = ContratoMutuo::create($input);
            $resultCreate['numero_contrato']  = str_pad($resultCreate->id.$datetime->format('m').$datetime->format('d'), 6, 0, STR_PAD_RIGHT);
            $resultCreate['valor_atualizado'] = $input['valor'];
            $resultCreate->save();
        }
        $contaResult = SaldoConta::where('user_id',$input['user_id'])->first();
        $total = $contaResult->valor + $input['valor'];
        $contaResult->valor =  $total;
        $contaResult->save();

    }

    public function calculaComissao($valor,$porcentagem)
    {
        if ($valor >= 1000 && $valor <= 5000) {
            if($porcentagem > 7){
                return 7;
            }else{
                return $porcentagem;
            }
        } else if ($valor <= 6000 && $valor <= 10000) {
            if($porcentagem > 6){
                return 6;
            }else{
                return $porcentagem;
            }
        } else if ($valor >= 11000 && $valor <= 20000) {
            if($porcentagem > 5){
                return 5;
            }else{
                return $porcentagem;
            }
        } else if ($valor >= 21000 && $valor <= 50000) {
            if($porcentagem > 4){
                return 4;
            }else{
                return $porcentagem;
            }
        } else if ($valor >= 51000) {
            if($porcentagem > 3){
                return 3;
            }else{
                return $porcentagem;
            }
        }
    }

    public function listProdutos(Request $request){
        if( Helper::getUsuarioAuthTipo() === "Administrador" ||  Helper::getUsuarioAuthTipo() === "Diretor" ||  Helper::getUsuarioAuthTipo() === "Gestor de analista"){
            if ($request->query()) {
                return $this->repository->search($request->query());
            } else {
                return $this->repository->with('user')->paginate(10);
            }

        }else if(Helper::getUsuarioAuthTipo() === "Analista Senior" ||  Helper::getUsuarioAuthTipo() === "Analista pleno" ||  Helper::getUsuarioAuthTipo() === "Parceiro"){
            $resultContratos = ContratoMutuo::with('user')->whereIn('user_id',Helper::getUsuarioAuthParent())->paginate(10);
            return response()->json($resultContratos, 201);
        }else{
            $resultContratos = ContratoMutuo::with('user')->where('user_id', Helper::getUsuarioAuthId())->paginate(10);
            return response()->json($resultContratos, 201);
        }

    }

    public function listProdutosCliente($id){
        $resultContratos = ContratoMutuo::where('user_id', $id)->paginate(10);
        return response()->json($resultContratos, 201);
    }

    public function contratosClientesLogado(){
        $userAuth = Auth::user();
        $resultContratos = ContratoMutuo::with('relatorio')->where('user_id', $userAuth->id)->get();
        return response()->json($resultContratos, 201);
    }

    public function ativarContrato($id){

    }

    public function gerarPdf($id){
        $contrato = ContratoMutuo::with('user')->where('id', $id)->first();

        //dd($resultContratos);
        return \PDF::loadView('contratoMutuo', compact('contrato'))
            // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
            ->download('contratoMutuo.pdf');
    }
}
