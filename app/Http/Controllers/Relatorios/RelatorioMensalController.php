<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\RelatorioMensal;
use Illuminate\Http\Request;
use App\Utils\Helper;

class RelatorioMensalController extends Controller
{
    private $repository;

    public function __construct(RelatorioMensal $relatorio)
    {
        $this->repository = $relatorio;
    }

    public function index(Request $request)
    {
        if ($request->query()) {
            return $this->repository->search($request->query());
        } else {
            return $this->repository->with('contrato', 'user.contaBancaria.banco')->orderBy('id')->paginate(10);
        }
    }

    public function indexAuth(Request $request)
    {
        if ($request->query()) {
            return $this->repository->search($request->query());
        } else {
            return $this->repository->with('contrato', 'user.contaBancaria.banco')->orderBy('data_referencia')->where('user_id',Helper::getUsuarioAuthId())->paginate(10);
        }
    }

  
}
