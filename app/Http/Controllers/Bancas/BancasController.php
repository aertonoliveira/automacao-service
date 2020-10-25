<?php

namespace App\Http\Controllers\Bancas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bancas\StoreBancaRequest;
use App\Http\Requests\Bancas\StoreBancaTradeRequest;
use App\Models\Role;
use App\User;
use App\Banca;
use App\BancaTrader;
use Carbon\Carbon;


class BancasController extends Controller
{
    private $repository;

    public function __construct(User $user)
    {
        $this->repository = $user;
    }

    public function create(StoreBancaRequest $request)
    {
        try {
            $userAuth = Auth::user();


            $new = $request->all();
            $new['data_pagamento'] = Carbon::now();
            $new['status'] = true;

            if ($request->hasFile('comprovante') && $request->file('comprovante')->isValid()) {
                $url = Storage::disk('s3')->put('images/bancas/comprovantes/'.$userAuth->id, $request->file('comprovante'),[ 'visibility' => 'public',]);
                $new['comprovante'] =$url;
            } else {
                return response()->json(['error' => 'Favor enviar somente imagens'], 409);
            }
            

            $resultCreate = Banca::create($new);

            return response()->json($resultCreate, 200);

        } catch (\Exception $error) {
            return [
                'status_code' => 400,
                'message' => $error->getMessage()
            ];
        }
    }

    public function createBancaTrader(StoreBancaTradeRequest $request)
    {
        try {
            $userAuth = Auth::user();


            $new = $request->all();
            $new['banca_id'] = Banca::where('user_id', $userAuth->id)->first()->id;
            $new['data_pagamento'] = Carbon::now();
            $new['status'] = true;

            if ($request->hasFile('comprovante') && $request->file('comprovante')->isValid()) {
                $url = Storage::disk('s3')->put('images/bancas/comprovantes/'.$userAuth->id, $request->file('comprovante'),[ 'visibility' => 'public',]);
                $new['comprovante'] =$url;
            } else {
                return response()->json(['error' => 'Favor enviar somente imagens'], 409);
            }
            

            $resultCreate = BancaTrader::create($new);

            return response()->json($resultCreate, 200);

        } catch (\Exception $error) {
            return [
                'status_code' => 400,
                'message' => $error->getMessage()
            ];
        }
    }


    public function listTrader()
    {
        try {
            $userAuth = Auth::user();


            $roleResult = User::with('roles')->where('role_id', 8)->get();

            return response()->json($roleResult, 200);

        } catch (\Exception $error) {
            return [
                'status_code' => 400,
                'message' => $error->getMessage()
            ];
        }
    }


}
