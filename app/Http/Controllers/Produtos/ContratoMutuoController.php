<?php

namespace App\Http\Controllers\Produtos;

use App\Models\ContratoMutuo;
use App\Models\Role;
use App\Models\SaldoConta;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ContratoMutuoController extends Controller
{
    public function create(Request $request)
    {
        $userAuth = Auth::user();

        $roleResult = Role::where('id', $userAuth->id)->first();
        $input = $request->all();
        $datetime = Carbon::now('America/Sao_Paulo');
        $input['inicio_mes'] = $datetime->format('Y-m-d H:i:s');
        $input['final_mes'] = date("Y-m-d H:i:s", strtotime($input['tempo_contrato'] . ' month'));
        $contaResult = SaldoConta::where('user_id',$input['user_id'])->first();
        $total = $contaResult->valor + $input['valor'];
        $contaResult->valor =  $total;
        $contaResult->save();

        if ($roleResult->name === 'Administrator' ) {
            ContratoMutuo::create($input);
        } else {
            $input['porcentagem'] = $this->calculaComissao($input['valor'], $input['porcentagem']);

            ContratoMutuo::create($input);
        }

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

    public function listProdutos(){
        $resultContratos = ContratoMutuo::with('user')->paginate(10);
        return response()->json(['data' => $resultContratos], 201);
    }

    public function listProdutosCliente($id){
        $resultContratos = ContratoMutuo::where('user_id', $id)->paginate(10);
        return response()->json(['data' => $resultContratos], 201);
    }


}
