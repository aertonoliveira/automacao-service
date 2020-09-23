<?php

namespace App\Console\Commands;

use App\Models\ContratoMutuo;
use App\Models\MetaCliente;
use App\User;
use App\Utils\Helper;
use Illuminate\Console\Command;

class RelatorioParceiro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parceiro:comissao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $from = date('2020-08-01');
        $to = date('2020-08-31');
        $resultUser = User::with('roles')->where('role_id',7)->get();

        foreach ($resultUser as $i) {
            $meusCLientes = ContratoMutuo::with('user')->whereBetween('inicio_mes', [$from, $to])->whereIn('user_id',Helper::getUsuarioParentClientes($i['id']))->sum('valor');
            $meusContratos = ContratoMutuo::with('user')->whereBetween('inicio_mes', [$from, $to])->where('user_id',$i['id'])->sum('valor');
            $metaIndividual = $meusCLientes + $meusContratos;
            $resultMeta = MetaCliente::whereBetween('inicio_mes', [$from, $to])->where('user_id',$i['id'] )->first();
            $resultMetaPleno = MetaCliente::whereBetween('inicio_mes', [$from, $to])->where('user_id',15 )->first();

            if($i['roles'][0]['name'] == 'Parceiro' ) {
                if ($resultMeta['meta_individual'] <= $metaIndividual) {
                    $totalMes = Helper::calcularValorPorcentagem(2.5, $metaIndividual);
                    $valorPleno = Helper::calcularValorPorcentagem(1, $metaIndividual);
                    $soma = $resultMetaPleno['mata_atingida'] + $valorPleno;


                    MetaCliente::where('id', $resultMeta['id'])->update([
                        'mata_atingida' => $totalMes,
                        'valor_mes' => $metaIndividual,
                    ]);

                    MetaCliente::where('id', $resultMetaPleno['id'])->update(['mata_atingida' => $soma, 'valor_parceiro' => $valorPleno]);
                } else {
                    $totalMes = Helper::calcularValorPorcentagem(1, $metaIndividual);
                    $valorPleno = Helper::calcularValorPorcentagem(1, $metaIndividual);


                    MetaCliente::where('id', $resultMeta['id'])->update(['mata_atingida' => $totalMes, 'valor_mes' => $metaIndividual]);
                    $soma = $resultMetaPleno['mata_atingida'] + $valorPleno;
                    MetaCliente::where('id', $resultMetaPleno['id'])->update(['mata_atingida' => $soma, 'valor_parceiro' => $valorPleno]);
                }
            }





        }
    }
}
