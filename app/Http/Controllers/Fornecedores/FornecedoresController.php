<?php

namespace App\Http\Controllers\Fornecedores;

use App\Http\Requests\Fornecedores\StoreFornecedorRequest;
use Illuminate\Http\Request;
use App\User;
use App\Models\Fornecedor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FornecedoresController extends Controller
{
    private $repository;

    public function __construct(Fornecedor $fornecedor)
    {
        $this->repository = $fornecedor;
    }

    public function index(Request $request){

        $userAuth = Auth::user();

        $result = Fornecedor::paginate(10);

        return response()->json($result, 200);

    }

    public function create(StoreFornecedorRequest $request)
    {

        $userAuth = Auth::user();

        $input = $request->all();

        $resultCreate = Fornecedor::create($input);

        return response()->json($resultCreate, 200);

    }

    public function update(StoreFornecedorRequest $request,$id){
        $userAuth = Auth::user();
        
        $input = $request->all();

        $fornecedor = Fornecedor::find($id);

        if($fornecedor){
            $result  = $fornecedor->update($input);
            return response()->json($result, 200);
        }

        return response()->json(['error' => 'Fornecedor não encontrado'], 409);

    }

    public function destroy($id)
    {
        $fornecedor = $this->repository->find($id);

        if($fornecedor){
            $result = $fornecedor->delete();
            return response()->json([], 204);
        }
        
        return response()->json(['error' => 'Fornecedor não encontrado'], 409);

        
    }
}
