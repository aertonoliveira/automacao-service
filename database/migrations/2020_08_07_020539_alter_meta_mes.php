<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMetaMes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meta_clientes', function (Blueprint $table) {
            $table->double('meta_mes')->nullable();
            $table->double('valor_carteira')->nullable();
            $table->double('porcentagem_valor_carteira')->nullable();
            $table->double('meta_atiginda_equipe')->nullable();
            $table->double('valor_mes')->nullable();
            $table->double('valor_meta_equipe')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meta_clientes', function (Blueprint $table) {
            $table->dropColumn('meta_mes')->nullable();
            $table->dropColumn('valor_carteira')->nullable();
            $table->dropColumn('porcentagem_valor_carteira')->nullable();
            $table->dropColumn('meta_atiginda_equipe')->nullable();
            $table->dropColumn('valor_mes')->nullable();
            $table->dropColumn('valor_meta_equipe')->nullable();
        });
    }
}
