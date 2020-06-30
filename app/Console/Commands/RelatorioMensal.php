<?php

namespace App\Console\Commands;

use App\Models\ContratoMutuo;
use App\Utils\Helper;
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
        $result = ContratoMutuo::all();
        foreach ($result as $i){
            $mesQuebrado  = explode("-", $i['inicio_mes']);
            $quantidadeDiasMes = Helper::retornaQuantidadeDias($mesQuebrado[1], $mesQuebrado[0]);
            $diasCalculados = Helper::diasParaCalcular($quantidadeDiasMes, $mesQuebrado[2]);
            $valorDivido = Helper::dividirDiasPorPorcentagem($quantidadeDiasMes, $i['porcentagem'], $mesQuebrado[2]);
            $valorPorcentagem = Helper::calcularValorPorcentagem($i['valor'], $valorDivido);

            echo 'data: '.$i['inicio_mes'];
            echo ' - ';
            echo 'dias do mês: '.$quantidadeDiasMes;
            echo ' - ';
            echo 'Dias Calculado: '. $diasCalculados ;
            echo ' - ';

            echo 'Porcentagem: '.$valorDivido;
            echo ' - ';
            echo 'Lucro: '.$valorPorcentagem;
            echo "\n";
        }
    }
}
