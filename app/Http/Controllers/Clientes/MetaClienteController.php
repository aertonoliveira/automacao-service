<?php

namespace App\Http\Controllers\Clientes;

use App\Models\MetaCliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MetaClienteController extends Controller
{
    private $repository;

    public function __construct(MetaCliente $relatorio)
    {
        $this->repository = $relatorio;
    }

    public function index(Request $request)
    {
        if ($request->query()) {
            return $this->repository->search($request->query());
        } else {
            return $this->repository->with( 'user.contaBancaria.banco')->orderBy('id')->paginate(10);
        }
    }
    public function create(Request $request){

        $input = $request->all();
        $datetime = Carbon::now('America/Sao_Paulo');
        $input['inicio_mes'] = $datetime->format('Y-m-d H:i:s');
        $input['final_mes'] = date("Y-m-d H:i:s", strtotime('3 days'));
        $input['status'] = 'ativa';
        $resultMeta = MetaCliente::create($input);

    }
}
