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
       //dd($request->query());
        if ($request->query()) {
            return $this->repository->search($request->query());
        } else {
            return $this->repository->with('contrato', 'user.contaBancaria.banco')->orderBy('id')->paginate(10);
        }
    }

    public function atualizarStatus(Request $request, $id){
        $input = $request->all();
        $result = RelatorioMensal::find($id);
        $result->status =  $input['status'];
        $result->save();
    }

    public function indexAuth(Request $request)
    {
        $ano = date('Y');
        $extrato = [];
        $arr_meses = Helper::montaArrayMeses();

        foreach($arr_meses as $mes => $meses) {

            $extrato[$meses] =   $this->repository->with('contrato', 'user')
                ->orderBy('data_referencia')
                ->where('user_id',Helper::getUsuarioAuthId())
                ->whereBetween('data_referencia', Helper::retornaIntervaloDatas($mes) )->get();
        }
//        dd($extrato);
//        $json = json_encode($extrato);
        return response()->json([
            'data' => $extrato,

        ]);


//        if ($request->query()) {
//            return $this->repository->search($request->query());
//        } else {
//            return $this->repository->with('contrato', 'user.contaBancaria.banco')->orderBy('data_referencia')->where('user_id',Helper::getUsuarioAuthId())->paginate(10);
//        }
    }


}
