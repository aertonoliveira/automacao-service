<?php

namespace App\Console\Commands;

use App\Models\ContratoMutuo;
use App\Utils\Helper;
use Illuminate\Console\Command;

class totalMetas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'total:geral';

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
        $from = date('2020-07-01');
        $to = date('2020-07-31');
        $totalClientes = \App\Models\RelatorioMensal::whereBetween('inicio_mes', [$from, $to])->sum('comissao');
        echo $totalClientes;
    }
}
