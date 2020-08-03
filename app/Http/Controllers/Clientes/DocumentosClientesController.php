<?php

namespace App\Http\Controllers\Clientes;

use App\Models\DocumentosClientes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DocumentosClientesController extends Controller
{
    public function create(Request $request){
        $date = Carbon::now();
        $name = uniqid(date('HisYmd'));

        $input = $request->all();

        if ($request->hasFile('frente_rg') && $request->file('frente_rg')->isValid()) {
            $url = Storage::disk('s3')->put('images/frente_rg'.$input['user_id'], $request->file('frente_rg'));
            $input['frente_rg'] = $url;;
        } else {
            return response()->json(['error' => 'Favor enviar somente imagens '], 409);
        }

        if ($request->hasFile('verso_rg') && $request->file('verso_rg')->isValid()) {
            $url = Storage::disk('s3')->put('images/frente_rg'.$input['user_id'], $request->file('frente_rg'));
            $input['verso_rg'] = $url;
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
