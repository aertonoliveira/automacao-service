<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\RelatorioMensal;
use Illuminate\Http\Request;
use App\Utils\Helper;
use Illuminate\Support\Facades\Storage;

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

    public function atualizarStatus(Request $request, $id){
        $input = $request->all();
        $result = RelatorioMensal::find($id);

        $result->status =  $input['status'];

        if ($request->hasFile('comprovante') && $request->file('comprovante')->isValid()) {
            $url = Storage::disk('s3')->put('images/comporvante/' . $id, $request->file('comprovante'), ['visibility' => 'public',]);
            $result->comprovante = $url;
        }
        $result->save();
    }

    public function indexAuth(Request $request)
    {

        $arr_meses = Helper::montaArrayMeses();
        $extrato  = [];
        foreach($arr_meses as $mes => $meses) {
            $i =   $this->repository->with('contrato', 'user')
                ->orderBy('data_referencia')
                ->where('user_id',Helper::getUsuarioAuthId())
                ->whereBetween('data_referencia', Helper::retornaIntervaloDatas($mes) )->get();
            $extrato[] = ['relatorio' => $i, 'mes' => $meses];
        }

        return response()->json( $extrato,200);
    }


}
