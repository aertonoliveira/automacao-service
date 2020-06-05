<?php

namespace App\Http\Controllers\Clientes;

use App\Models\MetaCliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MetaClienteController extends Controller
{
    public function create(Request $request){

        $input = $request->all();
        $datetime = Carbon::now('America/Sao_Paulo');
        $input['inicio_mes'] = $datetime->format('Y-m-d H:i:s');
        $input['final_mes'] = date("Y-m-d H:i:s", strtotime('3 days'));
        $input['status'] = 'ativa';
        $resultMeta = MetaCliente::create($input);

    }
}
