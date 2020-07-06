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
        $from = date('2020-06-01');
        $to = date('2020-06-30');
        $roleResult = Role::where('name','Analista pleno')->first();
        //dd($roleResult->id);
        $resultUser = User::with('roles')->where('role_id', $roleResult->id)->get();

        foreach ($resultUser as $i) {

            $resultContratos = ContratoMutuo::with('user')->whereBetween('inicio_mes', [$from, $to])->whereIn('user_id',Helper::getUsuarioParent($i['id']))->get();
            $somaMeta = 0;
            foreach($resultContratos as $item){

                $somaMeta = $somaMeta + $item['valor'];

            }


            $resultMeta = MetaCliente::whereBetween('inicio_mes', [$from, $to])
                            ->where('user_id',$i['id'] )->first();





            if($resultMeta['meta_individual'] <= $somaMeta){
                $todosContratos = ContratoMutuo::with('user')->whereIn('user_id',Helper::getUsuarioParent($i['id']))->get();
                $valorCarteira = 0;
                foreach($todosContratos as $item){
                    $valorCarteira = $valorCarteira + $item['valor'];
                }

                   $a = Helper::calcularValorPorcentagem(1, $valorCarteira);
                   $b = Helper::calcularValorPorcentagem(5, $somaMeta) ;
                   $soma = $a + $b;
                   echo "Valor Carteira: ".$a;
                   echo "\n";
                   echo "Valor Mês: ".$b;
                   echo "\n";
                   echo "Valor Total a Pagar: ".$soma;
            }
          }
          exit;

    }
}
