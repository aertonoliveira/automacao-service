<?php

namespace App\Http\Controllers\Clientes;

use App\Models\DocumentosClientes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentosClientesController extends Controller
{
    public function create(Request $request){
        $date = Carbon::now();
        $name = uniqid(date('HisYmd'));

        $input = $request->all();

        if ($request->hasFile('frente_rg') && $request->file('frente_rg')->isValid()) {
            $extension = $request->frente_rg->extension();
            $nameFile = "frente_rg.{$extension}";
            $request->frente_rg->storeAs('imagens/documentos/'. $input['user_id'] . '/'  . $date->month . '/' . $date->day, $nameFile);
            $input['frente_rg'] = 'storage/imagens/documentos/'.$input['user_id'] . '/'   . $date->month . '/' . $date->day . '/' . $nameFile;
        } else {
            return response()->json(['error' => 'Favor enviar somente imagens '], 409);
        }

        if ($request->hasFile('verso_rg') && $request->file('verso_rg')->isValid()) {
            $extension = $request->verso_rg->extension();
            $nameFile = "verso_rg.{$extension}";
            $request->verso_rg->storeAs('imagens/documentos/'. $input['user_id'] . '/'  . $date->month . '/' . $date->day, $nameFile);
            $input['verso_rg'] = 'storage/imagens/documentos/'.$input['user_id'] . '/'   . $date->month . '/' . $date->day . '/' . $nameFile;
        } else {
            return response()->json(['error' => 'Favor enviar somente imagens '], 409);
        }

        if ($request->hasFile('comprovante_residencia') && $request->file('comprovante_residencia')->isValid()) {
            $extension = $request->comprovante_residencia->extension();
            $nameFile = "comprovante_residencia.{$extension}";
            $request->comprovante_residencia->storeAs('imagens/documentos/'. $input['user_id'] . '/'  . $date->month . '/' . $date->day, $nameFile);
            $input['comprovante_residencia'] = 'storage/imagens/documentos/'.$input['user_id'] . '/'   . $date->month . '/' . $date->day . '/' . $nameFile;
        } else {
            return response()->json(['error' => 'Favor enviar somente imagens '], 409);
        }

        if ($request->hasFile('comprovante_pagamento') && $request->file('comprovante_pagamento')->isValid()) {
            $extension = $request->comprovante_pagamento->extension();
            $nameFile = "comprovante_pagamento.{$extension}";
            $request->comprovante_pagamento->storeAs('imagens/documentos/'. $input['user_id'] . '/'  . $date->month . '/' . $date->day, $nameFile);
            $input['comprovante_pagamento'] = 'storage/imagens/documentos/'.$input['user_id'] . '/'   . $date->month . '/' . $date->day . '/' . $nameFile;
        } else {
            return response()->json(['error' => 'Favor enviar somente imagens '], 409);
        }



        $resultCreate = DocumentosClientes::updateOrCreate(['user_id' =>$input['user_id']], $input);

        return response()->json($resultCreate, 200);

    }

    public function listDocumentos(Request $request ,$id){
        $roleResult = DocumentosClientes::with('user')->where('user_id',$id)->first();

        return response()->json($roleResult, 200);
    }


}
