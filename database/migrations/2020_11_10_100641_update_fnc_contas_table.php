<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFncContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnc_contas', function (Blueprint $table) {
            $table->integer('relatorio_id')->nullable();
            $table->integer('contrato_id')->nullable();
            $table->integer('fornecedor_id')->nullable();
            $table->integer('meta_cliente_id')->nullable();
            $table->integer('banca_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnc_contas', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('registro_id');
        });
    }
}
