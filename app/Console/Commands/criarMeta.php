<?php

namespace App\Console\Commands;

use App\Models\MetaCliente;
use App\Models\User;
use Illuminate\Console\Command;

class criarMeta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'criar:meta';

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
//        'meta_programada',
//        'mata_atingida',
//        'mata_faltando',
//        'inicio_mes',
//        'final_mes',
//        'status',
//        'ativo',
//        meta_individual
        $from = date('2021-01-01');
        $to = date('2021-01-31');
        $resultUser = User::with('roles')->get();

        foreach ($resultUser as $i) {
            $input['user_id']          =   $i['id'];
            $input['inicio_mes']    =   $from;
            $input['final_mes']     =   $to;
            $input['ativo']         =   true;
           if($i['roles'][0]['name'] == 'Gestor de analista'){
               $input['meta_individual']    = 5000;
               $input['meta_equipe']    = 1000000;

               MetaCliente::create($input);
           }else if($i['roles'][0]['name'] == 'Analista pleno'){
                $input['meta_individual']   = 20000;
               MetaCliente::create($input);
           }else if($i['roles'][0]['name'] == 'Analista Senior'){
               $input['meta_individual']    = 35000;
               $input['meta_equipe']    = 200000;
               MetaCliente::create($input);
           }else if($i['roles'][0]['name'] == 'Parceiro'){
               $input['meta_individual']   = 50000;
               MetaCliente::create($input);
           }
            $input['meta_equipe'] = 0;
        }

    }
}
