<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatorioMensalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorio_mensals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('contrato_id')->unsigned()->nullable();
            $table->foreign('contrato_id')->references('id')->on('contrato_mutuos');
            $table->timestamp('data_referencia');
            $table->integer('dias_calculados')->unsigned()->nullable();
            $table->decimal('porcentagem_calculada')->nullable();
            $table->decimal('porcentagem')->nullable();
            $table->double('valor_contrato')->nullable();
            $table->double('comissao')->nullable();
            $table->double('meta_individual')->nullable();
            $table->double('meta_equipe')->nullable();
            $table->double('pagar_total')->nullable();
            $table->boolean('status')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relatorio_mensals');
    }
}
