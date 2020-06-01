<?php

namespace App\Http\Controllers\Produtos;

use App\Models\ContratoMutuo;
use App\Models\Role;
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

        if ($roleResult->name === 'Administrator') {
            ContratoMutuo::create($input);
        } else {
            $input['porcentagem'] = $this->calculaComissao($input['valor']);
            ContratoMutuo::create($input);
        }

    }

    public function calculaComissao($valor)
    {
        if ($valor >= 1000 && $valor <= 5000) {
            return 7;
        } else if ($valor <= 6000 && $valor <= 10000) {
            return 6;
        } else if ($valor >= 11000 && $valor <= 20000) {
            return 5;
        } else if ($valor >= 21000 && $valor <= 50000) {
            return 4;
        } else if ($valor >= 51000) {
            return 3;
        }
    }

    public function listProdutos(){
        $resultContratos = ContratoMutuo::with('user')->paginate(10);

        return response()->json($resultContratos, 200);
    }

}
