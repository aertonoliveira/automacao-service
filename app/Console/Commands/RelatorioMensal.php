<?php

namespace App\Console\Commands;

use App\Models\ContratoMutuo;
use App\Utils\Helper;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class RelatorioMensal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculo:porcentagem';

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
        $from = date('2020-04-01');
        $to = date('2020-12-31');
        $result = ContratoMutuo::whereBetween('inicio_mes', [$from, $to])->get();
        $datetime =  Carbon::now('America/Sao_Paulo');
        $dataAtual = $datetime->format('Y-m-d H:i:s');
      
        foreach ($result as $i){
  
            $mesQuebrado  = explode("-", $i['inicio_mes']);

            if($i['tipo_contrato']== 'Composto'){

                if(is_null($i['agendamento_relatorio']) ){
                    $dataAtualQuebrada = explode("-", $i['inicio_mes']);
                    $mesAfrente =  $dataAtualQuebrada[1] + 1;
                    $dtToronto = Carbon::create($dataAtualQuebrada[0], $mesAfrente, 1, 0, 0, 0, 'America/Toronto');

                    $resultContrato = ContratoMutuo::find($i['id']);
                    $resultContrato->agendamento_relatorio = $dtToronto;
                    $resultContrato->save();
                }else{
                    $b = explode("-", $i['agendamento_relatorio']);
                    $c = explode(" ", $b[2]);

                    if( $mesQuebrado[1] !=$b[1]){
                        $mesQuebrado[2] = $c[0];

                    }

                    $dataAtualQuebrada = explode("-", $i['agendamento_relatorio']);
                    $mesAfrente =  $dataAtualQuebrada[1] + 1;
                    $dtToronto = Carbon::create($dataAtualQuebrada[0], $mesAfrente, 1, 0, 0, 0, 'America/Toronto');

                    $resultContrato = ContratoMutuo::find($i['id']);
                    $resultContrato->agendamento_relatorio = $dtToronto;
                    $resultContrato->save();

                }

                $quantidadeDiasMes = Helper::retornaQuantidadeDias($mesQuebrado[1], $mesQuebrado[0]);
                $input['dias_calculados'] = Helper::diasParaCalcular($quantidadeDiasMes , $mesQuebrado[2]);
                $input['porcentagem_calculada'] = Helper::dividirDiasPorPorcentagem(  $quantidadeDiasMes, $i['porcentagem'], $mesQuebrado[2]);
                $input['comissao'] = Helper::calcularValorPorcentagem($i['valor_atualizado'],  $input['porcentagem_calculada']);
                $input['data_referencia'] =  $to;
                $input['porcentagem'] = $i['porcentagem'];
                $input['valor_contrato'] = $i['valor'];
                $input['contrato_id'] = $i['id'];
                $input['user_id'] = $i['user_id'];
                $input['pagar_total'] =  $input['comissao'];



                $valorSomado =  $input['comissao'] +  $i['valor_atualizado'];
              //  dd( $valorSomado );
                $resultContrato = ContratoMutuo::find($i['id']);
                $resultContrato->valor_atualizado = $valorSomado;
                $resultContrato->save();



                $relatorioCreate = \App\Models\RelatorioMensal::create($input);

                $objConta = [
                    'id' => $relatorioCreate->id,
                    'titulo' => 'Conta de Relatório Mensal',
                    'valor' => $valorSomado,
                    'data_vencimento' => Carbon::now()->addDay(10)->toDateString(),
                    'tipo_registro' => 1, //relatorio
                    'tipo_conta' => 1, // a pagar
                ];

                $helper = new Helper();
                $helper->registroContas($objConta);


//                dd($input);
            }else{
                if(is_null($i['agendamento_relatorio']) ){
                    $dataAtualQuebrada = explode("-", $i['inicio_mes']);
                    $mesAfrente =  $dataAtualQuebrada[1] + 1;
                    $dtToronto = Carbon::create($dataAtualQuebrada[0], $mesAfrente, 1, 0, 0, 0, 'America/Toronto');

                    $resultContrato = ContratoMutuo::find($i['id']);
                    $resultContrato->agendamento_relatorio = $dtToronto;
                    $resultContrato->save();
                }else{
                    $b = explode("-", $i['agendamento_relatorio']);
                    $c = explode(" ", $b[2]);


                    if( $mesQuebrado[1] !=  $b[1]){
                        $mesQuebrado[2] = $c[0];
                    }
                    echo "\n". $mesQuebrado[2]."Dias\n" ;
                    $dataAtualQuebrada = explode("-", $i['agendamento_relatorio']);
                    $mesAfrente =  $dataAtualQuebrada[1] + 1;
                    $dtToronto = Carbon::create($dataAtualQuebrada[0], $mesAfrente, 1, 0, 0, 0, 'America/Toronto');

                    $resultContrato = ContratoMutuo::find($i['id']);
                    $resultContrato->agendamento_relatorio = $dtToronto;
                    $resultContrato->save();

                }

                $quantidadeDiasMes = Helper::retornaQuantidadeDias($mesQuebrado[1], $mesQuebrado[0]);
                $input['dias_calculados'] = Helper::diasParaCalcular($quantidadeDiasMes , $mesQuebrado[2]);

                $input['porcentagem_calculada'] = Helper::dividirDiasPorPorcentagem(  $quantidadeDiasMes, $i['porcentagem'], $mesQuebrado[2]);
                $input['comissao'] = Helper::calcularValorPorcentagem($i['valor'],  $input['porcentagem_calculada']);

                $input['data_referencia'] =  $to;
                $input['porcentagem'] = $i['porcentagem'];
                $input['valor_contrato'] = $i['valor'];
                $input['contrato_id'] = $i['id'];
                $input['user_id'] = $i['user_id'];
                $input['pagar_total'] =   $input['comissao'] +  $i['valor'];
                $valorSomado =  $input['comissao'] +  $i['valor_atualizado'];

                $resultContrato = ContratoMutuo::find($i['id']);
                $resultContrato->valor_atualizado = $valorSomado;
                $resultContrato->save();



                $relatorioCreate = \App\Models\RelatorioMensal::create($input);

                $objConta = [
                    'id' => $relatorioCreate->id,
                    'titulo' => 'Conta de Relatório Mensal',
                    'valor' => $valorSomado,
                    'data_vencimento' => Carbon::now()->addDay(10)->toDateString(),
                    'tipo_registro' => 1, //relatorio
                    'tipo_conta' => 1, // a pagar
                ];

                $helper = new Helper();
                $helper->registroContas($objConta);



            }
            echo "processado";
            echo "\n";
        }
    }
}
