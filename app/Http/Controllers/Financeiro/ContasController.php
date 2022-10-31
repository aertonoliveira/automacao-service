<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Requests\Financeiro\StoreContasRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FinanceiroConta;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContasController extends Controller
{
    private $repository;

    public function __construct(FinanceiroConta $conta)
    {
        $this->repository = $conta;
    }

    public function index(Request $request){

        $result = $this->repository::paginate(10);

        return response()->json($result, 200);

    }

    public function create(StoreContasRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('comprovante') && $request->file('comprovante')->isValid()) {
            $url = Storage::disk('s3')->put('images/financeiro/comprovantes/'.$userAuth->id, $request->file('comprovante'),[ 'visibility' => 'public',]);
            $input['comprovante'] =$url;
        } else if ($request->file('comprovante')) {
            return response()->json(['error' => 'Favor enviar somente imagens'], 409);
        }

        $resultCreate = $this->repository::create($input);

        return response()->json($resultCreate, 200);

    }

    public function update(StoreContasRequest $request,$id){

        $input = $request->all();

        $conta = $this->repository::find($id);

        if($conta){

            if ($request->hasFile('comprovante') && $request->file('comprovante')->isValid()) {
                $url = Storage::disk('s3')->put('images/financeiro/comprovantes/'.$userAuth->id, $request->file('comprovante'),[ 'visibility' => 'public',]);
                $input['comprovante'] =$url;
            } else if ($request->file('comprovante')) {
                return response()->json(['error' => 'Favor enviar somente imagens'], 409);
            }

            $result  = $conta->update($input);
            return response()->json($result, 200);
        }

        return response()->json(['error' => 'Conta não encontrada'], 409);

    }

    public function destroy($id)
    {
        $conta = $this->repository->find($id);

        if($conta){
            $result = $conta->delete();
            return response()->json([], 204);
        }

        return response()->json(['error' => 'Conta não encontrada'], 409);


    }


}
