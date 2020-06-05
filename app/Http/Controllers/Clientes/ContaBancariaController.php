<?php

namespace App\Http\Controllers\Clientes;

use App\Models\ContaBancaria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContaBancariaController extends Controller
{
    public function create(Request $request){
        $input = $request->all();
        $resultContaBanco = ContaBancaria::updateOrCreate(['user_id' =>$input['user_id']], $input);
        return response()->json(['data' => $resultContaBanco], 201);
    }
}
