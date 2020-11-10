<?php

namespace App\Console\Commands;

use App\Models\ContratoMutuo;
use App\Models\MetaCliente;
use App\Models\Role;
use App\User;
use App\Utils\Helper;
use Illuminate\Console\Command;

class relatorioAnalista extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pleno:comissao';

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
        $from = date('2020-09-01');
        $to = date('2020-09-30');
        $roleResult = Role::where('name', 'Analista pleno')->first();
        $resultUser = User::with('roles')->where('role_id', $roleResult->id)->get();

        foreach ($resultUser as $i) {

            $somaMetaMes = ContratoMutuo::with('user')->whereBetween('inicio_mes', [$from, $to])->whereIn('user_id', Helper::getUsuarioParent($i['id']))->sum('valor');
            $resultMeta = MetaCliente::whereBetween('inicio_mes', [$from, $to])->where('user_id', $i['id'])->first();

            if ($resultMeta['meta_individual'] <= $somaMetaMes) {
                $valorCarteira = ContratoMutuo::with('user')->whereIn('user_id', Helper::getUsuarioParent($i['id']))->sum('valor');

                $porcentagemCarteira = Helper::calcularValorPorcentagem(1, $valorCarteira);
                $totalMes = Helper::calcularValorPorcentagem(5, $somaMetaMes);
                $soma = $porcentagemCarteira + $totalMes;
                MetaCliente::where('id',$resultMeta['id'])->update([
                    'mata_atingida' => $soma,
                    'valor_mes' => $somaMetaMes,
                    'meta_mes' => $totalMes,
                    'valor_carteira' => $valorCarteira,
                    'porcentagem_valor_carteira' =>  $porcentagemCarteira
                ]);

                $objConta = [
                    'id' => $resultMeta->id,
                    'titulo' => 'Conta de Relatório Analista',
                    'valor' => $totalMes,
                    'data_vencimento' => Carbon::now()->addDay(10)->toDateString(),
                    'tipo_registro' => 1, //relatorio
                    'tipo_conta' => 1, // a pagar
                ];

                $helper = new Helper();
                $helper->registroContas($objConta);

            } else {
                $totalMes = Helper::calcularValorPorcentagem(5, $somaMetaMes);
                MetaCliente::where('id',$resultMeta['id'])->update(['mata_atingida' => $totalMes,'valor_mes' => $somaMetaMes]);

                $objConta = [
                    'id' => $resultMeta->id,
                    'titulo' => 'Conta de Relatório Analista',
                    'valor' => $totalMes,
                    'data_vencimento' => Carbon::now()->addDay(10)->toDateString(),
                    'tipo_registro' => 1, //relatorio
                    'tipo_conta' => 1, // a pagar
                ];

                $helper = new Helper();
                $helper->registroContas($objConta);
            }
        }

    }
}
