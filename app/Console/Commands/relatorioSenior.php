<?php

namespace App\Console\Commands;

use App\Models\ContratoMutuo;
use App\Models\MetaCliente;
use App\User;
use App\Utils\Helper;
use Illuminate\Console\Command;

class relatorioSenior extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'senior:comissao';

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
        $resultUser = User::with('roles')->where('role_id',4)->get();

        foreach ($resultUser as $i) {
            $metaIndividual = ContratoMutuo::with('user')->whereBetween('inicio_mes', [$from, $to])->whereIn('user_id',Helper::getUsuarioParentClientes($i['id']))->sum('valor');
            $metaEquipe = ContratoMutuo::with('user')->whereBetween('inicio_mes', [$from, $to])->whereIn('user_id',Helper::getUsuarioParentAnalistas($i['id']))->sum('valor');
            $resultMeta = MetaCliente::whereBetween('inicio_mes', [$from, $to])->where('user_id',$i['id'] )->first();

          if($i['roles'][0]['name'] != 'Cliente' &&   $i['roles'][0]['name'] != 'Diretor' && $i['roles'][0]['name'] != 'Administrador' ) {

              if ($resultMeta['meta_individual'] <= $metaIndividual) {
                  $valorCarteira = ContratoMutuo::with('user')->whereIn('user_id', Helper::getUsuarioParent($i['id']))->sum('valor');
                  $valorCarteira = $valorCarteira - $metaIndividual;
                  $porcentagemCarteira = Helper::calcularValorPorcentagem(1, $valorCarteira);
                  $porcentagemIndividual = Helper::calcularValorPorcentagem(7, $metaIndividual);
                  $soma = $porcentagemCarteira + $porcentagemIndividual;


                  MetaCliente::where('id', $resultMeta['id'])->update([
                      'mata_atingida' => $soma,
                      'valor_mes' => $metaIndividual,
                      'meta_mes' => $porcentagemIndividual,
                      'valor_carteira' => $valorCarteira,
                      'porcentagem_valor_carteira' => $porcentagemCarteira
                  ]);

                  $objConta = [
                    'titulo' => 'Conta de Relatório Senior',
                    'valor' => $soma,
                    'data_vencimento' => Carbon::now()->addDay(10)->toDateString(),
                    'tipo_registro' => 1, //relatorio
                    'tipo_conta' => 1, // a pagar
                    ];

                    Helper::registroContas($objConta);


              } else {
                  $totalMes = Helper::calcularValorPorcentagem(7, $metaIndividual);
                  echo Helper::calcularValorPorcentagem(7, $metaIndividual) . "\n";
                  echo $i['id'] . "\n";
                  echo $i['name'] . "\n";
                  echo "Meta Individual:" . $metaIndividual . "\n";
                  echo "Meta Individual:" . $resultMeta['meta_individual'];

                  MetaCliente::where('id', $resultMeta['id'])->update(['mata_atingida' => $totalMes, 'valor_mes' => $metaIndividual]);

                  $objConta = [
                    'titulo' => 'Conta de Relatório Senior',
                    'valor' => $totalMes,
                    'data_vencimento' => Carbon::now()->addDay(10)->toDateString(),
                    'tipo_registro' => 1, //relatorio
                    'tipo_conta' => 1, // a pagar
                    ];

                    Helper::registroContas($objConta);
              }
          }

          if($resultMeta['meta_equipe'] <= $metaEquipe){
              $porcentagemEquipe = Helper::calcularValorPorcentagem(1, $metaEquipe);
              $resultMetaEquipe = MetaCliente::where('id',$resultMeta['id'])->first();

              $soma = $porcentagemEquipe + $resultMetaEquipe->mata_atingida;

              MetaCliente::where('id',$resultMeta['id'])->update([
                  'meta_atiginda_equipe' => $porcentagemEquipe,
                  'valor_meta_equipe' => $metaEquipe,
                  'mata_atingida' => $soma,
              ]);

              $objConta = [
                    'id' => $resultMeta['id'],
                    'titulo' => 'Conta de Relatório Senior',
                    'valor' => $soma,
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
